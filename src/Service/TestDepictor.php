<?php

namespace App\Service;
use App\Entity\Test;

class TestDepictor 
{
	/** 
	 * Prepares array of tests (Test[]) to be depicted by 
	 * Bootstrap grid  
	 *
	 * @param App\Entity\Test[] $tests - tests to be prepared for depiction
	 * @param int $number_of_rows - number of rows in Bootstrap grid
	 *
	 * @return mixed[] $rows - array containing information about number of 
	 * tests to be depicted per each Bootstrap grid row and actual tests to
	 * be depicted in each row
	 */
	public function prepareTestsForDepiction(array $tests, int $number_of_rows): array 
	{
		$number_of_tests = count($tests);

		$remaining_number_of_tests = $number_of_tests;
    	$remaining_number_of_rows = $number_of_rows;

    	for ($i=0; $i < $number_of_rows; $i++) { 

    		$number_of_tests_per_row[$i] = round($remaining_number_of_tests/$remaining_number_of_rows);

    		$rows[$i]['length'] = $number_of_tests_per_row[$i];

    		$offset = $number_of_tests - $remaining_number_of_tests;

    		$rows[$i]['tests'] = array_slice($tests,$offset,$rows[$i]['length']);

    		$remaining_number_of_tests = $remaining_number_of_tests - $number_of_tests_per_row[$i];

    		$remaining_number_of_rows--;
    	}

    	return $rows;
	}
}