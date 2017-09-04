<?php 
	namespace Main\Form; 

	use Zend\Form\Form; 

	/**
	* AddProd
	*/
	class AddProd extends Form
	{

		// @var Doctrine\ORM\EntityManager
		private $manager; 

		// @param Doctrine\ORM\EntityManager
		function __construct($manager)
		{
			parent::__construct("AddProd"); 
			$this->manager = $manager; 
			$this->setAttribute("class","addProd"); 
			$this->createElements(); 
		}

		public function createElements()
		{
			$this->add([
				"type" => "text",
				"name" => "title",
				"options" => [
					"label" => "Product title",
				],
				"attributes" => [
					"id" => "title",
					"required" => 1,
					"placeholder" => "Min 4, max 40 symbols"
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "short",
				"options" => [
					"label" => "Short description",
				],
				"attributes" => [
					"id" => "short",
					"required" => 1,
					
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "description",
				"options" => [
					"label" => "Product description",
				],
				"attributes" => [
					"id" => "description",
					"required" => 1,
					
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "price",
				"options" => [
					"label" => "Product price",
				],
				"attributes" => [
					"id" => "price",
					"required" => 1,
					
				]
			]); 

			$this->add([
				"type" => "text",
				"name" => "rest",
				"options" => [
					"label" => "Rest of products",
				],
				"attributes" => [
					"id" => "rest",
					"required" => 1,
					
				]
			]); 

			$this->add([
				"type" => "DoctrineModule\Form\Element\ObjectSelect",
				"name" => "cat",
				"options" => [
					'object_manager' => $this->manager,
	                'target_class' => 'Application\Entity\Cats',
	                'property' => 'title',
					"label" => "Product category",
				],
				"attributes" => [
					"id" => "cat",
					"required" => 1,
					"value" => 1
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

			$this->add([
				"type" => "file",
				"name" => "otherPics",
				"options" => [
					"label" => "Other pictures"
				],
				"attributes" => [
					"required" => 0, 
					"id" => "other_pics",
					"multiple" => 1
				]
			]);  
		}
	}
 ?>