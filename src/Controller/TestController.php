<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Service\TestFetcher;
use App\Service\TestDepictor;
use App\Service\TestSubmissionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\SubmittedTest;
use App\Entity\SubmittedAnswer;
use App\Form\TestSubmissionType;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(TestFetcher $test_fetcher, TestDepictor $test_depictor)
    {
        $tests = $test_fetcher->fetchAllTests();

        $num_of_tests = count($tests);
        $num_of_columns = 3;
        $num_of_rows = round($num_of_tests/$num_of_columns);

    	$rows = $test_depictor->prepareTestsForDepiction($tests,$num_of_rows);

        return $this->render('test/index.html.twig', [
            'tests' => $tests,
            'n' => $num_of_rows,
            'rows' => $rows
        ]);
    }

    /**
     * @Route("/tests/{test_id}", name="specific_test", requirements={"test_id"="\d+"})
     */
    public function showSpecificTest($test_id, Request $request, TestFetcher $test_fetcher, TestSubmissionHandler $handler)
    {
    	$test_obj = $test_fetcher->fetchSpecificTest($test_id);
        $test = $handler->prepareTestForSubmissionForm($test_obj);

        $builder = $this->createFormBuilder();
        $form = $handler->buildSubmissionForm($builder,$test);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submitted_results = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $submitted_test_id = $handler->postSubmittedTestToDatabase($submitted_results,$entityManager,$test_obj);
            return $this->redirectToRoute('test_submission_results',['submitted_test_id'=>$submitted_test_id]);
        }

		return $this->render('test/specific_test.html.twig', [
            'test' => $test,
            'form' => $form->createView()
        ]);
    }
}
