<?php 
	return [
		"acl" => [
			"acl" => [
				"roles" => [
					"guest" => null,
					"member" => "guest",
					"admin" => "member"
				],
				"resources" => [
					"allow" => [
						"main" => [
							"index" => "guest",
							"cats" => "guest",
							"view" => "guest",
							"cart" => "guest",
							"checkout" => "guest"
						],
						"user" => [
							"index" => "member",
							"edit" => "member",
							"crop" => "member",
							"logout" => "member",
							"view-order" => "member",
							"signin" => "guest",
							"signup" => "guest",
							
						],
						"admin" => [
							"index" => "admin",
							"add-prod" => "admin",
							"edit-prod" => "admin",
							"remove-prod" => "admin",
							"add-cat" => "admin",
							"edit-cat" => "admin",
							"remove-cat" => "admin",
						]

					],
					"deny" => [
						"user" => [
							// "index" => "guest"
						]
					]
						 



						
				]
			]
		]
	];

?>