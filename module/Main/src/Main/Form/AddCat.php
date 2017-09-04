<?php 
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* AddCat
	*/
	class AddCat extends Form
	{

		// @var Doctrine\ORM\EntityManager
		private $manager; 

		// @param Doctrine\ORM\EntityManager
		function __construct($manager)
		{
			parent::__construct("AddCat"); 
			$this->manager = $manager; 
			$this->setAttribute("class","addCat"); 
			$this->createElements(); 
		}

		public function createElements()
		{
			$this->add([
				"type" => "text",
				"name" => "title",
				"options" => [
					"label" => "Category title",
				],
				"attributes" => [
					"id" => "title",
					"required" => 1,
					"placeholder" => "Min 4, max 40 symbols"
				]
			]); 

			$this->add([
				"type" => "file",
				"name" => "picture",
				"options" => [
					"label" => "Picture"
				],
				"attributes" => [
					"required" => 0, 
					"id" => "picture"
				]
			]); 
		}
	}
 ?>