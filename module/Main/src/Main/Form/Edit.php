<?php
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* Edit
	*/
	class Edit extends Form
	{
		
		function __construct()
		{
			parent::__construct("Edit"); 
			$this->setAttribute("class","editForm"); 
			$this->createElements(); 
		}

		public function createElements()
		{
			$this->add([
				"type" => "text",
				"name" => "nick",
				"options" => [
					"label" => "Nick"
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
					"label" => "Email"
				],
				"attributes" => [
					"required" => 1, 
					"id" => "email"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "cell",
				"options" => [
					"label" => "cell"
				],
				"attributes" => [
					"required" => 1, 
					"id" => "cell"
				]
			]); 

			$this->add([
				"type" => "file",
				"name" => "avatar",
				"options" => [
					"label" => "Avatar"
				],
				"attributes" => [
					"required" => 0, 
					"id" => "avatar"
				]
			]); 

			

			
		}
	}

?>