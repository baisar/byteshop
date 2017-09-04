<?php 
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter; 

	/**
	* CheckoutFilter
	*/
	class CheckoutFilter extends InputFilter
	{
		
		function __construct()
		{
			$this->add([
				"name" => "name",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 4,
							"max" => 20
						]
					],
					[
						"name"=> "NotEmpty"
					]
				]
			]); 

			$this->add([
				"name" => "cell",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 9,
							"max" => 9
						]
					],
					[
						"name"=> "Digits"
					]
				]
			]); 

			$this->add([
				"name" => "email",
				"required" => 1,
				"validators" => [
					[
						"name" => "EmailAddress",
					],
				]
			]); 


			$this->add([
				"name" => "address",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 4,
							"max" => 100
						]
					],
					[
						"name"=> "NotEmpty"
					]
				]
			]); 
			$this->add([
				"name" => "comment",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 4,
							"max" => 200
						]
					],
					[
						"name"=> "NotEmpty"
					]
				]
			]); 
		}
	}

 ?>