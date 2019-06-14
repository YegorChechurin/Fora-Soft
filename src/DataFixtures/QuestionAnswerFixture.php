<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\Answer;

class QuestionAnswerFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $question_types = ['true/false','one_answer','many_answers'];

        $answer_correctness = ['correct','wrong'];

        $dummy_answers_count = 1;

        for ($i=0; $i < 25; $i++) { 
        	$q = new Question();
        	$ref_number = $i+1;
        	$q->setWording('Some dummy question formulation '.$ref_number);
            $q->setType($question_types[mt_rand(0,2)]);
            $q_type = $q->getType();
            if ($q_type=='true/false') {
                $a1 = new Answer();
                $a1->setType('true/false');
                $a1->setWording('True');
                $a1->setCorrectness($answer_correctness[mt_rand(0,1)]);
                $a2 = new Answer();
                $a2->setType('true/false');
                $a2->setWording('False');
                if ($a1->getCorrectness()=='correct') {
                    $a2->setCorrectness('wrong');
                } else {
                    $a2->setCorrectness('correct');
                }
                $manager->persist($a1);
                $manager->persist($a2);
                $q->addAnswer($a1);
                $q->addAnswer($a2);
            } elseif ($q_type=='one_answer') {
                $a = new Answer();
                $a->setType('worded');
                $a->setWording('Some dummy answer '.$dummy_answers_count);
                $dummy_answers_count++;
                $a->setCorrectness('correct');
                $manager->persist($a);
                $q->addAnswer($a);
            } elseif ($q_type=='many_answers') {
                for ($j=0; $j < 5; $j++) { 
                    $a = new Answer();
                    $a->setType('worded');
                    $a->setWording('Some dummy answer '.$dummy_answers_count);
                    $dummy_answers_count++;
                    $a->setCorrectness($answer_correctness[mt_rand(0,1)]);
                    $manager->persist($a);
                    $q->addAnswer($a);
                }
            }
        	$this->addReference('q'.$ref_number,$q);
        	$manager->persist($q);
        }

        $manager->flush();
    }
}
