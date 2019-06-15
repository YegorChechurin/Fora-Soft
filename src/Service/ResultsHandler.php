<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Test;
use App\Entity\SubmittedTest;
use App\Entity\SubmittedAnswer;

class ResultsHandler 
{
	public function prepareResults(SubmittedTest $submitted_test_object, Test $test_object): array
	{
		$test_name = $test_object->getName();

		if ($submitted_test_object->getDate()) {
			$submission_date = $submitted_test_object->getDate()->format('Y-m-d H:i:s');
		}

		$questions_obj = $test_object->getQuestions();
		$sub_answers_obj = $submitted_test_object->getSubmittedAnswers();

		$i = 0;
		foreach ($questions_obj as $q) {

			$questions[$i]['wording'] = $q->getWording();
			$answers_obj = $q->getAnswers();

			foreach ($answers_obj as $a) {
				if ($a->getCorrectness()=='correct') {
					$correct_answers[$i][] = $a->getWording();
				}
			}

			$questions[$i]['correct_answers'] = $correct_answers[$i];

			foreach ($sub_answers_obj as $sa) {
    			if ($sa->getQuestionId()==$q) {
    				$submitted_answers[$i][] = $sa->getAnswer();
    			}
    		}

    		$questions[$i]['submitted_answers'] = $submitted_answers[$i];

			$i++;

		}

		$results = [
			'submission_date'=>$submission_date,
			'test_name'=>$test_name,
			'questions'=>$questions
		];

		return $results;
	}
}