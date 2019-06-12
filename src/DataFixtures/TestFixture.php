<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Test;
use App\DataFixtures\QuestionFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TestFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$j = 1;
        for ($i=0; $i < 5; $i++) { 
        	$t = new Test();
        	$ref_number = $i+1;
        	$t->setName('Test '.$ref_number);
        	for ($k=0; $k < 5; $k++) { 
        		$t->addQuestion($this->getReference('q'.$j));
        		$j++;
        	}
        	$manager->persist($t);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            QuestionFixture::class,
        );
    }
}
