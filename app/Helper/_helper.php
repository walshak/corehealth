<?php

use Illuminate\Http\Request;

	/**
 	 *
 	 * @var  integer [REFERENCE RANDOM NUMBER LENGTH]
 	 */
 	CONST REFERENCE_RANDOM_NUMBER_LENGTH = 4;

 	/**
 	 *
 	 * @var  integer [REFERENCE RANDOM NUMBER LENGTH]
 	 */
 	CONST STATE_CODE = 31;

	function generateTinNumber($state_code)
	{
		$dt = Carbon::now();
		$timestamp = $dt->hour . $dt->minute . $dt->second;
		$referenceNumber = randomDigits(REFERENCE_RANDOM_NUMBER_LENGTH);
		return $referenceNumber . $timestamp . STATE_CODE;
	}

	/**
 	 *
 	 * @var  integer [REFERENCE RANDOM NUMBER LENGTH]
 	 */
 	// CONST STATE_CODE = 31;

	function generateLinNumber($state_id, $lga_id)
	{
		$dt = Carbon::now();
		$timestamp = $dt->minute . $dt->second;
		$referenceNumber = randomDigits(REFERENCE_RANDOM_NUMBER_LENGTH);
		return $state_id . '-' . $referenceNumber . '-' . $timestamp . '-' . $lga_id;
	}

	/**
	 * [Random digits generator]
	 *
	 * @param  [integer] $numDigits   	[Number of digits]
	 *
	 * @return [string]             	[Access Code]
	 */
	function randomDigits($numDigits) {
		if ($numDigits <= 0) {
			return '';
		}
		return mt_rand(1, 9) . randomDigits($numDigits - 1);
	}



	