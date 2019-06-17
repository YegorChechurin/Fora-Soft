<?php

namespace App\Service;

use App\Repository\SubmittedTestRepository;
use App\Entity\SubmittedTest;

class SubmittedTestFetcher 
{
	/** 
	 * @param App\Repository\SubmittedTestRepository 
	 */
	private $repo;

	public function __construct(SubmittedTestRepository $repositary) 
	{
		$this->repo = $repositary;
	}

	public function fetchSpecificSubmittedTest($id): ?SubmittedTest 
	{
    	$test = $this->repo->findOneBy(['id'=>$id]);
    	return $test;
	}

	public function fetchAllTestsForUser($user_id): ?array 
	{
		$sub_tests_obj = $this->repo->findAllForUserReverse($user_id);

		if ($sub_tests_obj) {
			$i = 0;
	        foreach ($sub_tests_obj as $o) {
	            $sub_test_id = $o->getId();
	            if ($o->getDate()) {
	                $date = $o->getDate()->format('Y-m-d H:i:s');
	            } else {
	                $date = null;
	            }
	            $name = $o->getTestId()->getName();
	            $sub_tests[$i]['id'] = $sub_test_id;
	            $sub_tests[$i]['date'] = $date;
	            $sub_tests[$i]['name'] = $name;
	            $i++;
	        }
		} else {
			$sub_tests = null;
		}

		return $sub_tests;
	}
}