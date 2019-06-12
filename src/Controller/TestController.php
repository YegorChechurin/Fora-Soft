<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Repository\TestRepository;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
    	$test_repo = $this->getDoctrine()->getRepository(Test::class);
    	$all_tests = $test_repo->findAll();
    	$i = 0;
    	foreach ($all_tests as $test) {
    		$tests[$i]['name'] = $test->getName();
    		$questions = $test->getQuestions();
    		$j = 0;
    		foreach ($questions as $q) {
    			$tests[$i]['q'][$j] = $q->getWording();
    			$j++;
    		}
    		$i++;
    	}
        return $this->render('test/index.html.twig', [
            'tests' => $tests,
        ]);
    }
}
