<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Repository\TestRepository;
use App\Form\WordedAnswerType;
use App\Form\TrueFalseAnswerType;
use App\Form\ManyAnswersQuestionType;
use App\Form\TrueFalseQuestionType;
use App\Form\OneAnswerQuestionType;
use App\Form\QuestionType;
use App\Form\EmptyQuestionType;

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
    		$tests[$i]['id'] = $test->getId();
    		$tests[$i]['name'] = $test->getName();
    		$tests[$i]['d'] = $test->getDescription();
    		$i++;
    	}

    	$num_of_tests = $i;
    	$num_of_rows = round($i/3);

    	$remaining_number_of_tests = $num_of_tests;
    	$remaining_number_of_rows = $num_of_rows;

    	for ($i=0; $i < $num_of_rows; $i++) { 
    		$num_of_tests_per_row[$i] = round($remaining_number_of_tests/$remaining_number_of_rows);
    		$rows[$i]['length'] = $num_of_tests_per_row[$i];
    		$offset = $num_of_tests - $remaining_number_of_tests;
    		$rows[$i]['tests'] = array_slice($tests,$offset,$rows[$i]['length']);
    		$remaining_number_of_tests = $remaining_number_of_tests - $num_of_tests_per_row[$i];
    		$remaining_number_of_rows--;
    	}

        return $this->render('test/index.html.twig', [
            'tests' => $tests,
            'n' => $num_of_rows,
            'rows' => $rows
        ]);
    }

    /**
     * @Route("/tests/{test_id}", name="specific_test", requirements={"test_id"="\d+"})
     */
    public function show_specific_test($test_id)
    {
    	$test_repo = $this->getDoctrine()->getRepository(Test::class);
    	$test_obj = $test_repo->findOneBy(['id'=>$test_id]);
    	$test['name'] = $test_obj->getName();
		$questions = $test_obj->getQuestions();
		$i = 0;
		foreach ($questions as $q) {
			if ($q->getType()=='true/false') {
				$forms[$i] = $this->createForm(TrueFalseQuestionType::class,$q);
			} elseif ($q->getType()=='one_answer') {
				$forms[$i] = $this->createForm(OneAnswerQuestionType::class,$q);
			} else {
				$forms[$i] = $this->createForm(ManyAnswersQuestionType::class,$q);
			}
			$forms_empty[$i] = $this->createForm(QuestionType::class,$q);
            $empty_form_views[$i] = $forms_empty[$i]->createView();
			$form_views[$i] = $forms[$i]->createView();
			$test['q'][$i]['w'] = $q->getWording();
			$answers_obj = $q->getAnswers();
			$j = 0;
			foreach ($answers_obj as $a) {
				$test['q'][$i]['a'][$j] = $a->getWording();
				$j++;
			}
			$i++;
		}

		return $this->render('test/specific_test.html.twig', [
            'test' => $test,
            'forms' => $form_views,
            'empty_forms' => $empty_form_views
        ]);
    }
}
