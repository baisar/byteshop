<?php 
	namespace Main\Filter; 

	use Zend\InputFilter\InputFilter,
		Zend\Filter\File\RenameUpload,
		Zend\Validator\File\IsImage,
		Zend\Validator\File\ImageSize,
		Zend\Validator\File\Size, 
		Zend\Validator\File\Extension ; 

	/**
	* AvaFilter
	*/
	class AvaFilter extends InputFilter
	{		
		function __construct($fileName)
		{
			$this->add([
				"name" => "avatar",
				"required" => 1,
				"validators" => [
					[ "name" => IsImage::class]
				,	[ "name" => ImageSize::class,
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
	                        'target' => './public/img/user/'.$fileName,
	                        "overwrite" => true,
	                    	"use_upload_extension" => true,
	                    	"use_upload_name" => false
	                    ]
	                ]
	            ]
			]); 
		}
	}

 ?>