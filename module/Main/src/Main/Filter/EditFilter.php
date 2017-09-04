<?php 
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter; 

	/**
	* EditFilter
	*/
	class EditFilter extends InputFilter
	{
		
		function __construct($manager,$sameEmail)
		{
			$this->add([
				"name" => "nick",
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
				],
				"filters" => [
					["name" => "StripTags"],
					["name" => "StringTrim"]
				]
			]); 
			if(!$sameEmail){
				$this->add([
					"name" => "email",
					"required" => 1,
					"validators" => [
						[
							"name" => "EmailAddress",
						],
						[
							"name" => "DoctrineModule\Validator\NoObjectExists",
							"options" => [
								"object_repository" => $manager->getRepository("Application\Entity\User"),
								"fields" => "email",
								"messages" => array(
									"objectFound" => "Пользователь с таким тел. уже зарегистрирован"
								)
							]
						],
					],
					"filters" => [
						["name" => "StripTags"],
						["name" => "StringTrim"]
					]
				]); 
			}
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
				],
				"filters" => [
					["name" => "StripTags"],
					["name" => "StringTrim"]
				]
			]); 
		}
	}

 ?>