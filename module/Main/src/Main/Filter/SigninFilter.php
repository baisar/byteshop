<?php
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter; 

	/**
	* SigninFilter
	*/
	class SigninFilter extends InputFilter
	{
		
		function __construct()
		{

			$this->add([
				"name" => "email",
				"required" => true,
				"validators" => [
					[
						"name" => "EmailAddress",
					],
				],
				"filters" => [
					["name" => "StripTags"],
					["name" => "StringTrim"]
				]
			]); 

			$this->add([
				"name" => "pass",
				"required" => true,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => "4",
							"max" => "20",
						]
					],
				],
				"filters" => [
					["name" => "StripTags"],
					["name" => "StringTrim"]
				]
			]); 

			$this->add([
				"name" => "checkbox",
				"required" => false
			]); 
		}
	}