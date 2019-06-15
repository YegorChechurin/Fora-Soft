<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Test;
use App\Service\TestFetcher;
use App\Entity\SubmittedTest;
use App\Entity\SubmittedAnswer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Form; 
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TestSubmissionHandler 
{
	public function prepareTestForSubmissionForm(Test $test_object): array 
	{
		$test_id = $test_object->getId();
		$test_name = $test_object->getName();
		$questions_obj = $test_object->getQuestions();

		$i = 0;
		foreach ($questions_obj as $q) {
			$questions[$i]['id'] = $q->getId();
			$questions[$i]['type'] = $q->getType();
			$questions[$i]['wording'] = $q->getWording();
			$answers_obj = $q->getAnswers();
			$j = 0;
			foreach ($answers_obj as $a) {
				$answers[$j] = $a->getWording();
				$j++;
			}
			$questions[$i]['answers'] = $answers;
			$i++;
		}

		$test = [
			'id'=>$test_id,
			'name'=>$test_name,
			'questions'=>$questions
		];

		return $test;
	}

	public function buildSubmissionForm(FormBuilderInterface $builder, array $test): Form 
	{
		$i = 0;

		foreach ($test['questions'] as $q) {

			$question_number = $i+1;

			if ($q['type']=='one_answer') {

				$builder->add(
					$builder->create('question_'.$question_number, FormType::class)
							/*->add('question_id', HiddenType::class, 
								['data'=>$q['id']])*/
							->add('answers', TextType::class, [
								'label'=>$q['wording'],
								'attr'=>['placeholder'=>'Type your answer here']
							])
				);

			} elseif ($q['type']=='true/false') {

				$builder->add(
					$builder->create('question_'.$question_number, FormType::class)
							/*->add('question_id', HiddenType::class, 
								['data'=>$q['id']])*/
							->add('answers', ChoiceType::class, [
								'label'=>$q['wording'],
								'choices'=>['True'=>'True','False'=>'False'],
								'expanded'=>true,
								'multiple'=>false
							])
				);

			} else {

				$choices = array_combine($q['answers'],$q['answers']);

				$builder->add(
					$builder->create('question_'.$question_number, FormType::class)
							/*->add('question_id', HiddenType::class, 
								['data'=>$q['id']])*/
							->add('answers', ChoiceType::class, [
								'label'=>$q['wording'],
								'choices'=>$choices,
								'expanded'=>true,
								'multiple'=>true,
								'constraints' => [
					                new NotBlank()
					            ]
							])
				);

			}

			$i++;
		}

		$builder->add('Post your answers', SubmitType::class);

		$form = $builder->getForm();

		return $form;
	}

	public function postSubmittedTestToDatabase(array $submitted_results, EntityManagerInterface $entityManager, Test $test): ?int 
	{
		$submitted_test = new SubmittedTest();
		$submitted_test->setTestId($test)
				       /*->setDate(new \DateTime());*/
				       ->setDate(\DateTime::createFromFormat('Y-m-d H:i:s',\date('Y-m-d H:i:s')));

		$questions = $test->getQuestions();
		$i = 0;
		foreach ($submitted_results as $r) {
			foreach ($r as $a) {
				$question_type = $questions[$i]->getType();
				if ($question_type=='many_answers') {
					foreach ($a as $key => $value) {
						$submitted_answer = new SubmittedAnswer();
						$submitted_answer->setSubmittedTestId($submitted_test)
								 ->setQuestionId($questions[$i])
						         ->setAnswer($value);
						$entityManager->persist($submitted_answer);
					}
				} else {
					$submitted_answer = new SubmittedAnswer();
					$submitted_answer->setSubmittedTestId($submitted_test)
							 ->setQuestionId($questions[$i])
					         ->setAnswer($a);
					$entityManager->persist($submitted_answer);
				}
			}
			$i++;
		}

		$entityManager->persist($submitted_test);

        $entityManager->flush();

        $submitted_test_id = $submitted_test->getId();

        return $submitted_test_id;
	}
}