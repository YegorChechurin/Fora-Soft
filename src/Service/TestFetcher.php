<?php

namespace App\Service;

use App\Repository\TestRepository;
use App\Entity\Test;

class TestFetcher 
{
	/** 
	 * @param App\Repository\TestRepository 
	 */
	private $test_repo;

	public function __construct(TestRepository $test_repositary) 
	{
		$this->test_repo = $test_repositary;
	}

	public function fetchAllTests(): ?array 
	{
		$all_tests = $this->test_repo->findAll();
    	$i = 0;
    	foreach ($all_tests as $test) {
    		$tests[$i]['id'] = $test->getId();
    		$tests[$i]['name'] = $test->getName();
    		$tests[$i]['d'] = $test->getDescription();
    		$i++;
    	}
    	return $tests;
	}

	public function fetchSpecificTest($test_id): ?Test 
	{
    	$test = $this->test_repo->findOneBy(['id'=>$test_id]);
    	return $test;
	}
}