<?php 
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter,
		Zend\Filter\File\RenameUpload; 

	use Zend\Validator\File\{IsImage, ImageSize, Size, Extension};  

	/**
	* ProductFilter
	*/
	class ProductFilter extends InputFilter
	{
		
		function __construct()
		{
			$this->add([
				"name" => "title",
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

			$this->add([
				"name" => "short",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 4,
							"max" => 500
						]
					],
					[
						"name"=> "NotEmpty"
					]
				]
			]); 

			$this->add([
				"name" => "description",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 4,
							"max" => 1000
						]
					],
					[
						"name"=> "NotEmpty"
					]
				]
			]); 

			$this->add([
				"name" => "price",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 1,
							"max" => 10
						]
					],
					[
						"name"=> "Digits"
					]
				]
			]); 

			$this->add([
				"name" => "rest",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 1,
							"max" => 10
						]
					],
					[
						"name"=> "Digits"
					]
				]
			]); 

			//

			$this->add([
				"name" => "cat",
				"required" => 1,
				"validators" => [
					[
						"name" => "StringLength",
						"options" => [
							"min" => 1,
							"max" => 10
						]
					],
					[
						"name"=> "Digits"
					]
				]
			]); 


			$this->add([
				"name" => "picture",
				"required" => false,
				"validators" => [
					[ "name" => IsImage::class],
					[ "name" => ImageSize::class,
						"options" => [
							"minWidth" => 100,
							"maxWidth" => 5000,
							"minHeight" => 100,
							"maxHeight" => 5000
						]
					],
					[
						"name" => Size::class,
						"options" => [
							"max" => "5MB"
						]
					],
					[
						"name" => Extension::class,
						"options" => [
							"extension" => ["jpeg","png","JPG"]
 						]
					]
				],
				'filters' => [
	                [
	                    'name' => RenameUpload::class,
	                    'options' => [
	                        'target' => './public/img/products',
	                        // "overwrite" => true,
	                    	"use_upload_extension" => true,
	                    	"use_upload_name" => false,
	                    	"randomize" => 1
	                    ]
	                ]
	            ]
			]); 

			$this->add([
				"name" => "otherPics",
				"required" => false,
				"validators" => [
					[ "name" => IsImage::class],
					[ "name" => ImageSize::class,
						"options" => [
							"minWidth" => 100,
							"maxWidth" => 5000,
							"minHeight" => 100,
							"maxHeight" => 5000
						]
					],
					[
						"name" => Size::class,
						"options" => [
							"max" => "5MB"
						]
					],
					[
						"name" => Extension::class,
						"options" => [
							"extension" => ["jpeg","png","JPG"]
 						]
					]
				],
				'filters' => [
	                [
	                    'name' => RenameUpload::class,
	                    'options' => [
	                        'target' => './public/img/products',
	                        // "overwrite" => true,
	                    	"use_upload_extension" => true,
	                    	"use_upload_name" => false,
	                    	"randomize" => 1
	                    ]
	                ]
				]
			]); 
		}
	}

 ?>