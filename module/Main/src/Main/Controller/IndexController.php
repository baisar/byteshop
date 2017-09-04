<?php
	namespace Main\Controller; 

#fzCB8wVOBv
#passpass455SS14
	use Zend\Mvc\Controller\AbstractActionController,
		Application\Entity\Orders,
		Zend\Session\Container,
		Zend\View\Model\ViewModel,
		DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator, 
		Main\Form\Checkout,
		Main\Filter\CheckoutFilter; 
		

	/**
	* IndexController
	*/
	class IndexController extends AbstractActionController
	{
		// @var Doctrine\ORM\EntityManager
		private $manager; 

		// @param Doctrine\ORM\EntityManager
		public function __construct($manager)
		{
			$this->manager = $manager;
			
		}
		public function indexAction()
		{
			// Doctrine\ORM\EntityManager

			$manager = $this->manager; 

			// get products to show on main page
			$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u"); 
			$result = $query->getResult(); 

			return [
				"products" => $result, 
			]; 
		}

		/*
		 * Action where all cats are shown
		*/
		public function catsAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// if get param was provided for filter by cat
			$id = $this->params()->fromRoute("id"); 

			// get cat products by id or get categories
			if($id): 
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u WHERE u.cat = $id"); 
				$result = $query->getResult(); 
				// if cat id was provided by GET param, show products, so it's better to use different view phtml
				$view = new ViewModel(["products" => $result]); 
				$view->setTemplate("main\index\products"); 
				return $view; 
			else: 
				// get cats from db
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Cats u"); 
			endif; 
			$result = $query->getResult(); 				

			return [
				"cats" => $result,
			]; 
		}

		/*
		 * Action where products are shown, 
		 * accepts GET param for filter by cat
		*/
		public function productsAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			return [
				"products" => $result,
				//
			]; 
		}

		// view product
		public function viewAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// get id from route in order to get product by id
			$id = ceil($this->params()->fromRoute("id")); 
			// redirect user if no id was provided
			if(!$id) return $this->redirect()->toRoute("home"); 

			// get product by id
			$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u WHERE u.id = $id"); 

			$result = $query->getResult(); 
			if(isset($result[0])):
				return [
					"product" => $result[0],
				]; 
			else: 
				// kick to mainpage if no product was found in db
				return $this->redirect()->toRoute("home"); 
			endif; 
		}

		// Cart
		public function cartAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 
			
			$container = new Container("cart"); 
			// if cart session of user is not empty
			if(is_array($container->orders)): 
				// get array keys of order session to separate array, in order to get products from db
				$ids = []; 
				foreach ($container->orders as $key => $value) {
					$ids[] = $key; 
				}
				// get products
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u WHERE 
					u.id IN (:ids) ")
					->setParameters(["ids" => $ids]); 
				$result = $query->getResult(); 
				
				return [
					"products" => $result,
					// return session to show quantity of products user wants to buy
					"orders" => $container->orders
					//
				]; 
				//
			endif; 
						 
		}

		// add to cart action, accepts ajax request with id to insert to cart session if user
		public function addToCartAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 


			$request = $this->getRequest(); 
			if($request->isPost()){
				$data = $request->getPost(); 
				// product id
				$id = ceil($data->id); 
				if(!$id):
					echo json_encode(["status" => "error","error" => "No id was provided"]); 
					exit(); 
				endif; 
				// check product if exist with such id which was provided from AJAX
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u WHERE u.id=$id"); 
				$result = $query->getResult(); 
				if(!isset($result[0])):
					echo json_encode(["status" => "error","error" => "No product was found for the id"]); 
					exit(); 
				endif; 
				// create or insert to cart session id of the product
				$container = new Container("cart"); 

				if(!is_array($container->orders)):
					$container->orders = [$id => 1]; 
				else: 
					if($container->orders[$id]) $container->orders[$id]++; 
					else $container->orders[$id] = 1; 
				endif; 

				// get total items of the cart
				$totalItems = 0; 
				if(is_array($container->orders)){
					foreach ($container->orders as $key => $value) {
						$totalItems += $value; 
					}
				}

				echo json_encode([
					"status" => "ok",
					"totalItems" => $totalItems
					]); 
				exit(); 
			}

			// redirect to home page in no POST, as this action is used only by AJAX
			return $this->redirect()->toRoute("home"); 
		}

		// checkout
		public function checkoutAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			$order = new Orders; 
			$form = new Checkout; 
			$form->setHydrator(new DoctrineHydrator($manager,"Application\Entity\Orders")); 

			// get user repo, and bind to the form
			if($this->identity()): 
				$userId = $this->identity()->getId(); 
				$repo = $manager->getRepository("Application\Entity\User")->findBy(["id" => $userId]); 
				if(isset($repo[0])) $form->bind($repo[0]); 
			endif; 

			// if user submitted form from checkout, save the order in db
			if($this->getRequest()->isPost()){
				// if it's an AJAX request from checkout
				if($this->getRequest()->getPost()->checkout == 1){
					$form->setData($this->getRequest()->getPost()); 
					$form->setInputFilter(new CheckoutFilter); 
					$form->bind($order); 
					if($form->isValid()):
						
						//set datetime
						$date = new \DateTime(); 
						$order->setOrderDate($date->setTimezone(new \DateTimeZone("Asia/Almaty"))); 

						// save prod_ids 
						$container = new Container("cart"); 
						if(is_array($container->orders)):
							$order->setCart(json_encode($container->orders)); 
						else:
							echo json_encode(["status" => "error","error" => "empty cart"]); 
							exit(); 
						endif; 

						// if current user is ordering
						if($this->identity()) $order->setUser($this->identity());

						$manager->persist($order); 
						$manager->flush(); 
						echo json_encode(["status" => "ok"]); 

						// clear cart session
						unset($container->orders); 
					else: 
						echo json_encode($form->getMessages()); 
					endif; 

					exit(); 
				}
			} 


			// session cart
			$container = new Container("cart"); 
			if(empty($container->orders) || !is_array($container->orders)) return $this->redirect()->toRoute("main",["action" => "cart"]); 
			

			// get prod ids to array
			$ids = []; 
			foreach($container->orders as $key => $value):
				$ids[] = $key; 
			endforeach;  
			// get products 
			$query = $manager->createQuery(" SELECT u FROM Application\Entity\Products u WHERE
				u.id IN (:ids)
				")->setParameters(["ids" => $ids]); 

			$result = $query->getResult(); //

			return [
				"form" => $form,
				"products" => $result,
				"orders" => $container->orders
			]; 
		}

		// remove product from cart 
		//  action is used by AJAX to remove product from the cart of user
		public function removeProductFromCartAction(){
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 
			$request = $this->getRequest(); 

			if($request->isPost()):
				$data = $request->getPost(); 

				// removeAll products from cart
				if($data->removeAll == 1): 
					$container = new Container("cart"); 
					// remove array containing products
					unset($container->orders); 
					echo json_encode(["status" => "ok"]); 

					exit(); 
				endif; 

				// product id to remove from cart
				$id = ceil($data->id); 
				if(!$id):
					echo json_encode(["status" => "error","error" => "no id was provided"]); 
					exit(); 
				endif; 
				// cart session of user
				$container = new Container("cart"); 
				if(is_array($container->orders)):
					// delete product from cart session of user
					unset($container->orders[$id]); 
					if(empty($container->orders)) $hideAll = 1; 
					else $hideAll = 0; 
					echo json_encode(["status" => "ok","hideAll" => $hideAll]); 
					exit(); 
				endif; 
			endif; 

			return $this->redirect()->toRoute("home"); 
		}
	}