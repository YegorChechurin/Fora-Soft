<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Test;
use App\Service\TestFetcher;
use App\Service\TestDepictor;
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
    public function showSpecificTest($test_id, TestFetcher $test_fetcher, TestDepictor $test_depictor)
    {
    	$test_obj = $test_fetcher->fetchSpecificTest($test_id);
        $test = $test_depictor->prepareTestForForm($test_obj);
    	/*$test['name'] = $test_obj->getName();
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
		}*/

		return $this->render('test/specific_test.html.twig', [
            'test' => $test,
            /*'forms' => $form_views,
            'empty_forms' => $empty_form_views*/
        ]);
    }
}
