<?php 
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter,
		Zend\Filter\File\RenameUpload; 

	use Zend\Validator\File\{IsImage, ImageSize, Size, Extension};  

	/**
	* AddCatFilter
	*/
	class AddCatFilter extends InputFilter
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
				"name" => "picture",
				"required" => 1,
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
	                        'target' => './public/img/cats',
	                        "overwrite" => true,
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