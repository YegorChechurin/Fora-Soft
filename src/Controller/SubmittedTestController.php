<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ResultsHandler;
use App\Service\SubmittedTestFetcher;
use App\Entity\SubmittedTest;

class SubmittedTestController extends AbstractController 
{
    private $handler;

    private $fetcher;

    public function __construct(ResultsHandler $handler, SubmittedTestFetcher $fetcher)
    {
        $this->handler = $handler;

        $this->fetcher = $fetcher;
    }
	/**
     * @Route("/submitted_tests/{submitted_test_id}", name="test_submission_results", requirements={"submitted_test_id"="\d+"})
     */
    public function showSubmittedResults($submitted_test_id)
    {
    	$sub_test_repo = $this->getDoctrine()->getRepository(SubmittedTest::class);
    	$sub_test_obj = $sub_test_repo->find($submitted_test_id);

        // Only the user who has submitted the test can view its results
        $this->denyAccessUnlessGranted('view', $sub_test_obj);

    	$test_obj = $sub_test_obj->getTestId();

        $results = $this->handler->prepareResults($sub_test_obj,$test_obj);

        return $this->render('test/test_results.html.twig', [
        	'results'=>$results
        ]);
    }

    /** 
     * @Route("profile/{user_id}/submitted_tests", name="all_user_submitted_tests", requirements={"user_id"="\d+"}) 
     */
    public function showAllUserSubmittedTests($user_id) 
    {
        $sub_tests = $this->fetcher->fetchAllTestsForUser($user_id);

        return $this->render('test/user_all_tests.html.twig', [
            'tests'=>$sub_tests
        ]);
    }
}