<?php
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter; 

	/**
	* RegisterFilter
	*/
	class RegisterFilter extends InputFilter
	{
		
		function __construct($manager)
		{
			$this->add([
				"name" => "nick",
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
				"name" => "email",
				"required" => true,
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
				"name" => "rpass",
				"required" => true,
				"validators" => [
					[
						"name" => "identical",
						"options" => [
							"token" => "pass"
						]
					]
				],
				"filters" => [
					["name" => "StripTags"],
					["name" => "StringTrim"]
				]
			]); 
		}
	}