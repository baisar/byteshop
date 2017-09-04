 <?php
 	/*
		Navigation
 	*/
	return [
		"navigation"=>[
			"default"=>[
				[
					"label" => "Home",
					"route" => "home",
					"icon" => "home",
				],
				[
					"label" => "Categories",
					"route" => "main",
					"action" => "cats",
					"icon" => "filter"
				],
				[
					"label" => "Cart",
					"route" => "main",
					"action" => "cart",
					"icon" => "shopping_cart",
					"pages"=>[
						[
							"route" => "main",
							"action" => "checkout",
						]
					]
				],
				[
					"label" => "Sign in/up",
					"route" => "user",
					"action" => "signin",
					"icon" => "person",
					"pages" => [
						[
							"route"=> "user",
							"action" => "signup",
						],
						["route" => "user"]
					]
				],
				[
					"label" => "My page",
					"route" => "user",
					"action" => "index",
					"icon" => "person"
				],
			],

			"second_navigation" => [
				[
					"label" => "Магазины",
					"route" => "shops",
					"action" => "all",
					"icon" => "shop",
					"pages" => [
						["route" => "shops"],
						["route" => "kanzler"],
						["route" => "konditer"],
						["route" => "prod"],
						["route" => "clothes"],
						["route" => "dish"],
						["route" => "strmat"],
						["route" => "dishwash"],
						["route" => "boots"],
						["route" => "comp"],
						["route" => "hometech"],
						["route" => "furniture"],
						["route" => "oboi"]
					]
				],
				[
					"label" => "Рестораны",
					"route" => "food",
					"action" => "all",

					"icon" => "restaurant",
					"pages" => [
						["route" => "food"],
						["route" => "restaurants"],
						["route" => "fastfood"]
					]
				],
				[
					"label" => "Гостиницы",
					"route" => "hotels",
					"action" => "all",
					"icon" => "hotel",
					"pages" => [
						["route" => "hotels"],
						["route" => "hostels"],
						["route" => "hotelsall"],
					]
				],
				[
					"label" => "Банки",
					"route" => "banks",
					"icon" => "account_balance",
					"pages" => [
						["route" => "banks","action" => "view"]
					]
				],
				[
					"label" => "Акции дня",
					"route" => "main",
					"action" => "akci",
					"icon" => "star",
				],
				
			],
			"blocks" => [
				[
					"label" => "Продаю",
					"route" => "prodau",
					"action" => "cats",
					"icon" => "card_giftcard"
					
				],
				[
					"label" => "Куплю",
					"route" => "kuplu",
					"icon" => "shopping_cart"
				],
				[
					"label" => "Услуги",
					"route" => "service",
					"action" => "cats",
					"icon" => "settings",
				],
				[
					"label" => "Работа",
					"route" => "work",
					"action" => "cats",
					"icon" => "work",
				],
				[
					"label" => "Аренда",
					"route" => "arenda",
					"action" => "cats",
					"icon" => "home",
				],
			],
		],
		"service_manager"=>[
			"factories"=>[
				"navigation" => "Zend\Navigation\Service\DefaultNavigationFactory",
				"second_navigation" => "Main\Navigation\SecondaryNavigationFactory",
				"blocks" => "Main\Navigation\BlocksNavigationFactory",
			]
		]
	];
	