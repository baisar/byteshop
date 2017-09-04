<?php 
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* Checkout
	*/
	class Checkout extends Form
	{		
		function __construct()
		{
			parent::__construct("Checkout"); 
			$this->setAttribute("class","checkout"); 
			$this->createElements(); 
		}
		public function createElements(){
			$this->add([
				"type" => "text",
				"name" => "name",
				"options" => [
					"label" => "Contact name",
				],
				"attributes" => [
					"required" => 1, "id" => "name"
				]
			]); 
			$this->add([
				"type" => "text",
				"name" => "cell",
				"options" => [
					"label" => "Contact number",
				],
				"attributes" => [
					"required" => 1, "id" => "cell"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "email",
				"options" => [
					"label" => "Contact email",
				],
				"attributes" => [
					"required" => 1,"id" => "email"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "address",
				"options" => [
					"label" => "Address to deliver",
				],
				"attributes" => [
					"required" => 1,"id" => "address"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "comment",
				"options" => [
					"label" => "Would you like to say anything?",
				],
				"attributes" => [
					"required" => 1,
					"id" => "comments"
				]
			]);
		}
	}


 ?>