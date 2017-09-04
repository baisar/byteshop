<?php
	namespace Main\Controller; 

	use Zend\Mvc\Controller\AbstractActionController,
		Zend\View\Model\ViewModel,
		Application\Entity\User,
		Zend\Http\Header\SetCookie,
		DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;  
	use	Main\Filter\{EditFilter,AvaFilter,SigninFilter,RegisterFilter}; 
	use Main\Form\{Register as RegisterForm, Signin as SigninForm,Edit}; 
	use Zend\Session\{Container,SessionManager}; 
	
	/**
	* UserController
	*/
	class UserController extends AbstractActionController
	{
		// @var Doctrine\ORM\EntityManager
		private $manager; 

		// @var Doctrine Authentication
		private $auth; 

		// @param Doctrine\ORM\EntityManager
		public function __construct($manager,$auth)
		{
			$this->manager = $manager; 
			$this->auth = $auth; 
		}
		public function indexAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// if user was redirected after signin and user chose to save cookies
			$cookie = $this->params()->fromQuery("cookie"); 
			if($cookie):
				if(isset($this->getRequest()->getCookie()->shop)): 
					$setCookie = new SetCookie("shop",$this->identity()->getPass(),time() + 60*60*24*4,"/");
		            $this->getResponse()->getHeaders()->addHeader($setCookie);
		        endif; 
			endif; 

			// get user order
			if($this->identity()):
				$userId = $this->identity()->getId(); 
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Orders u WHERE u.user = $userId"); 
				$result = $query->getResult(); 

				return [
					"orders" => $result,
					//
				]; 
			endif; 
			
		}

		
		 // * Action signin		
		public function signinAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 	

			$form = new SigninForm; 
			$form->setHydrator(new DoctrineHydrator($manager,"Application\Entity\User")); 
			$form->setInputFilter(new SigninFilter); 
			$request = $this->getRequest(); 
			if($request->isPost()): 
				$data = $request->getPost(); 
				$form->setData($data); 
				if($form->isValid()):
					// Doctrine auth
					$adapter = $this->auth->getAdapter(); 

					// if to save in cookies
					if(isset($data->checkbox)) $checkbox = 1;
					else $checkbox = 0; 

					$adapter->setIdentity($data->email); 
					$adapter->setCredential(md5($data->pass)); 

					$authRes = $this->auth->authenticate(); 

					if($authRes->isValid()):
						// start session
						$this->auth->getStorage()->write($this->identity()); 
						// if user chose to save cookies

						if($checkbox):
							$setCookie = new \Zend\Http\Header\SetCookie("beks",$this->identity()->getPass(),time() + 60*60*24*4,"/");
	                		$this->getResponse()->getHeaders()->addHeader($setCookie);
						endif; 						                	

						echo json_encode(["status" => "ok","checkbox" => $checkbox]); 
					else: 
						echo json_encode(["status" => "error","desc" => "wrong user data"]); 
					endif; 
					
					exit(); 					
				else: 
					echo json_encode($form->getMessages()); 
					exit(); 
				endif; 
			endif; 

			return [
				"form" => $form,
				//
			]; 				
		}

		/*
		 * Singup 
		*/
		public function signupAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 	

			$user = new User; 
			$form = new RegisterForm; 
			// @param Doctrine\ORM\EntityManager for checking if any user already uses email
			$form->setInputFilter(new RegisterFilter($manager)); 
			$form->setHydrator(new DoctrineHydrator($manager,"Application\Entity\User")); 
			$form->bind($user); 
			$request = $this->getRequest(); 

			if($request->isPost()):
				$data = $request->getPost(); 
				$form->setData($data); 

				if($form->isValid()){
					/*
					 * Setting empty fields (reg_dates,tokens,etc); 
					*/
					$date = new \DateTime(); 
					$user->setRegDate($date->setTimezone(new \DateTimeZone("Asia/Almaty"))); 
					// create token for email confirmation
					$user->setToken(md5(rand(100,999).$date->format("H:i:s"))); 
					$user->setRegisteredFromIp($_SERVER["REMOTE_ADDR"]); 
					// convert pass to md5
					$user->setPass(md5($data->pass)); 
					// setRole
					$user->setRole(2);

					// save in db
					$manager->persist($user); 
					$manager->flush(); 
					
					// evth is ok
					echo json_encode(["status" => "ok"]); 
					exit(); 
				}
				else{
					echo json_encode($form->getMessages()); 
					exit(); 
				}
			endif; 

			return[
				"form" => $form,
				//
			]; 	
		}

		// user data edit
		public function editAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 
			// user edit form
			$form = new Edit; 

			// avatar form
			$avaForm = new Edit; 

			$form->setHydrator(new DoctrineHydrator($manager,"Application\Entity\User")); 

			// get repository of the current user
			$repo = $manager->getRepository("Application\Entity\User")->findBy(["id" => $this->identity()->getId()]); 
			if(!isset($repo[0])):
				return $this->redirect()->toRoute("user",["action" => "signin"]); 
			endif; 

			$form->bind($repo[0]); 

			// session container of user
			$container = new Container("user"); 

			$request = $this->getRequest(); 
			// AJAX from index.js
			if($request->isPost()):
				$data = $request->getPost(); 

				// upload ava
				if($data->ava == 1): 
					$files = $request->getFiles(); 
					// temporary ava img name
					$date = new \DateTime(); 
					$fileName = $date->format("YmdHis");  
					
					$avaForm->setInputFilter(new AvaFilter($fileName)); 
					$avaForm->setHydrator(new DoctrineHydrator($manager,"Application\Entity\User")); 
					$avaForm->bind($repo[0]); 
					$avaForm->setData($files); 
					if($avaForm->isValid()): 
						// save in session temporary fileName
						// get ext of the session file name to be cropped
						$dir = scandir("public/img/user/"); 
						if(is_array($dir)):
							foreach($dir as $key => $value): 
								if(preg_match("/{$fileName}/", $value)) $fileName = $value; 
							endforeach; 
						endif; 
						
						// save in db, get user repo
						$repo = $manager->getRepository("Application\Entity\User")->findBy([
							"id" => $this->identity()->getId()
							]); 
						$repo[0]->setAvatar($fileName); 
						// clear old thumbnail
						$repo[0]->setThumbnail(null); 
						$manager->persist($repo[0]); 
						$manager->flush(); 

						echo json_encode(["status" => "ok"]); 
					else:
						echo json_encode($avaForm->getMessages()); 
					endif; 
					exit(); 
				endif; 	
				
				// as filter checks if email is already used, if the email of the form isnot changed, check if other user uses submitted email
				if($data->email == $repo[0]->getEmail()) $sameEmail = 1; 
				else $sameEmail = 0; 
				$form->setInputFilter(new EditFilter($manager,$sameEmail)); 
				$form->setData($data); 

				if($form->isValid()): 
					$manager->persist($repo[0]); 
					$manager->flush(); 
					echo json_encode(["status" => "ok"]); 
				else:
					echo json_encode($form->getMessages()); 
				endif; 
				
				exit(); 
			endif; 

			return [
				"form" => $form,
				"avaForm" => $avaForm,
			] ; 
		}

		// img crop
		public function cropAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			$container = new Container("user"); 
			// echo $container->fileName; 
			if($this->identity()->getAvatar()):
				$request = $this->getRequest(); 
				if($request->isPost()):
					$data = $request->getPost(); 

					//
					if(isset($data->x1) && isset($data->x2) && isset($data->y1) && isset($data->y2)): 
						// crop the img and save
						$imagine = new \Imagine\Gd\Imagine();
						$size    = new \Imagine\Image\Box($data->breite,$data->hohe);
						// $mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND; 
						$image = $imagine->open('public/img/user/'.$this->identity()->getAvatar()); 
						$image->resize(new \Imagine\Image\Box($data->imgWidth,$data->imgHeight))
							->crop(new \Imagine\Image\Point($data->x1,$data->y1),$size)
							// ->thumbnail($size,$mode)
							->resize(new \Imagine\Image\Box(270,270))
							->save("public/img/user/user".$this->identity()->getAvatar()); 

						// save in db, get user repo
						$repo = $manager->getRepository("Application\Entity\User")->findBy([
							"id" => $this->identity()->getId()
							]); 
						$repo[0]->setThumbnail($this->identity()->getAvatar()); 
						$manager->persist($repo[0]); 
						$manager->flush(); 
						
						echo json_encode(["status"=>"ok"]);  
						//
					else:
						echo json_encode(["status"=>"error","error" => "no coordinates"]); 
					endif; 
					
					exit(); 
				else:  
					// return 
				endif; 
				//
			else: 
				return $this->redirect()->toRoute("user"); 				
			endif; 
		}

		// logout action

		public function logoutAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			$clear = $this->auth;
			$clear->clearIdentity();
			$cookie = new SetCookie("shop","",time() - 1,"/");
			$this->getResponse()->getHeaders()->addHeader($cookie);
			return $this->redirect()->toRoute("user",["action" => "signin"]);
		}

		// view order
		public function viewOrderAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager;

			// order id, kick if not exist
			$id = ceil($this->params()->fromRoute("id"));
			if(!$id || !$this->identity()) return $this->redirect()->toRoute("user");

			$userId = $this->identity()->getId(); 
			// get order repo by id
			$repo = $manager->getRepository("Application\Entity\Orders")->findBy([
				"id"=>$id,
				"user" => $userId
				]); 
			
			// as products are kept as json in order
			$array = $prodCounts = [];
			if(isset($repo[0])) if($repo[0]->getCart()){
				$ar = $prodCounts = json_decode($repo[0]->getCart(),1);
				foreach ($ar as $key => $value) {
					$array[] = $key;
				}
			} 
			$result = [];
			if(!empty($array)){
				$query = $manager->createQuery("SELECT u FROM Application\Entity\Products u WHERE 
					u.id IN (:array)
					")
					->setParameters(["array"=>$array]);
				$result = $query->getResult();
				// echo count($result);
				// print_r($array); 
			}

			return [
				"repo" => $repo,
				"products"=>$result,
				"prodCounts" => $prodCounts,
			];
		}



		// remove order
		public function removeOrderAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager;

			// get id
			$id = $this->params()->fromRoute("id");

			$request = $this->getRequest();

			if($request->isPost()){
				if(!$id){
					echo json_encode(["status"=>"error","error"=>"no id"]);
					exit;
				}
				if(!$this->identity()){
					echo json_encode(["status"=>"error","error"=>"no identity"]);
					exit;
				}
				// get order repo by id
				$repo = $manager->getRepository("Application\Entity\Orders")->findBy([
					"id"=>$id,
					"user" => $this->identity()->getId()
					]); 
				if(!isset($repo[0])){
					echo json_encode(["status"=>"error","error"=>"no repo"]);
					exit;
				}
				// remove
				$manager->remove($repo[0]);
				$manager->flush();
				echo json_encode(["status"=>"ok"]);
				exit;
			}
			return $this->redirect()->toRoute("user");
		}
	}