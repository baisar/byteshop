<?php 
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* Register
	*/
	class Register extends Form
	{
		
		function __construct()
		{
			parent::__construct("Register"); 
			$this->setAttribute("class","register"); 
			$this->createElements(); 
		}

		public function createElements()
		{
			$this->add([
				"type" => "text",
				"name" => "nick",
				"options" => [
					"label" => "Nick",
				],
				"attributes" => [
					"required" => 1,
					"id" => "nick"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "email",
				"options" => [
					"label" => "Email",
				],
				"attributes" => [
					"required" => 1,
					"id" => "email"
				]
			]); 

			$this->add([
				"type" => "password",
				"name" => "pass",
				"options" => [
					"label" => "Password",
				],
				"attributes" => [
					"required" => 1,
					"id" => "pass"
				]
			]); 

			$this->add([
				"type" => "password",
				"name" => "rpass",
				"options" => [
					"label" => "Repeat password",
				],
				"attributes" => [
					"required" => 1,
					"id" => "rpass"
				]
			]); 
		}
	}

?>