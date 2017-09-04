<?php
	return [
		"controllers" => [
			"factories" => [
				"IndexController" => Main\Factory\IndexControllerFactory::class,
				"UserController" => Main\Factory\UserControllerFactory::class,
				"AdminController" => Main\Factory\AdminControllerFactory::class
			]
		],
		"router" => [
			"routes" => [
				"main" => [
					"type" => "segment",
					"options" => [
						"route" => "[/:action][/:id]", 
						"constraints" => [
							"action" => "[a-zA-Z0-9_-]*",
							"id" => "[0-9]*"
						],
						"defaults" => [
							"controller" => "IndexController",
							"action" => "index"
						]
					]
				],
				"user" => [
					"type" => "segment",
					"options" => [
						"route" => "/user[/:action][/:id]", 
						"constraints" => [
							"action" => "[a-zA-Z0-9_-]*",
							"id" => "[0-9]*"
						],
						"defaults" => [
							"controller" => "UserController",
							"action" => "index"
						]
					]
				],
				"admin" => [
					"type" => "segment",
					"options" => [
						"route" => "/admin[/:action][/:id]", 
						"constraints" => [
							"action" => "[a-zA-Z0-9_-]*",
							"id" => "[0-9]*"
						],
						"defaults" => [
							"controller" => "AdminController",
							"action" => "index"
						]
					]
				]
			]
		],
		"view_manager" => [
			"template_path_stack" => [
				__DIR__."/../view"
			]
		],
		'translator' => [
		    'locale' => "ru_RU",
		    'translation_file_patterns' => [
		        [
		            'type'     => 'gettext',
		            'base_dir' => __DIR__ . '/../language',
		            'pattern'  => '%s.mo',
		        ],
		    ],
		],
	];