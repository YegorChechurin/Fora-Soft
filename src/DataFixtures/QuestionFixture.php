<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Question;

class QuestionFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 25; $i++) { 
        	$q = new Question();
        	$ref_number = $i+1;
        	$q->setWording('Question '.$ref_number);
        	$this->addReference('q'.$ref_number,$q);
        	$manager->persist($q);
        }

        $manager->flush();
    }
}
