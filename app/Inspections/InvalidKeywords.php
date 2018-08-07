<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
	protected $keywords = [
		'yahoo customer support'
	];

	public function detect($body)
	{
		foreach ($this->keywords as $keywords) {
			if(stripos($body, $keywords) !== false) {
			    throw new Exception('Your reply contains spam');            
			}
		}
	}
}