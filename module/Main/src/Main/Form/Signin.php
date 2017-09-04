<?php 
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* Signin
	*/
	class Signin extends Form
	{
		
		function __construct()
		{
			parent::__construct("Signin"); 
			$this->setAttribute("class","singin"); 
			$this->createElements(); 
		}

		public function createElements()
		{
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

			$this->add(array(
				"name" => "checkbox",
				"type" => "checkbox",
				"options" => array(
					"label" => "Remember me"
				),
				"attributes" => array(
					"id" => "inputPassword"
				)
			));
		}
	}

?>