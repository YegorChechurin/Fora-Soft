<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ResultsHandler;
use App\Entity\SubmittedTest;

class SubmittedTestController extends AbstractController 
{
	/**
     * @Route("/submitted_tests/{submitted_test_id}", name="test_submission_results", requirements={"submitted_test_id"="\d+"})
     */
    public function showSubmittedResults($submitted_test_id, ResultsHandler $handler)
    {
    	$sub_test_repo = $this->getDoctrine()->getRepository(SubmittedTest::class);
    	$sub_test_obj = $sub_test_repo->find($submitted_test_id);
    	$test_obj = $sub_test_obj->getTestId();

        $results = $handler->prepareResults($sub_test_obj,$test_obj);

        return $this->render('test/test_results.html.twig', [
        	'results'=>$results
        ]);
    }
}