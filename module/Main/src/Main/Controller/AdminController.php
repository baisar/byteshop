<?php
	namespace Main\Controller; 

	use Zend\Mvc\Controller\AbstractActionController; 
	use	Application\Entity\{Orders, Products,Cats}; 
	use	Zend\Session\Container,
		Zend\View\Model\ViewModel,
		DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator; 
	use	Main\Form\{Checkout,AddProd,AddCat}; 
	use	Main\Filter\{CheckoutFilter, ProductFilter, AddCatFilter}; 
		

	/**
	* AdminController
	*/
	class AdminController extends AbstractActionController
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

			// get cats
			$query = $manager->createQuery("SELECT u.id,u.title FROM Application\Entity\Cats u "); 
			$result = $query->getResult(); 

			$query2 = $manager->createQuery(" SELECT u.id,u.nick,u.email,u.regDate,u.emailConfirmed FROM Application\Entity\User u"); 
			$result2 = $query2->getResult(); 

			$query3 = $manager->createQuery(" SELECT u.id,u.orderDate FROM Application\Entity\Orders u "); 
			$result3 = $query3->getResult(); 		

			// get catIds to count products related to appropriate cat
			if(is_array($result)): 
				$catIds = []; 
				foreach($result as $cat): 
					$catIds[] = $cat["id"]; 
				endforeach; 
			endif; 

			if(isset($catIds)) if(is_array($catIds)): 
				$productsCount = []; 
				foreach($catIds as $cat){
					$query4 = $manager->createQuery(" SELECT u FROM Application\Entity\Products u WHERE u.cat = $cat "); 
					$result4 = $query4->getResult(); 
					$productsCount[$cat] = count($result4); 
				}				
			endif; 
			if(!isset($productsCount)) $productsCount = 0; 
			// print_r($productsCount); 
			return [
				"cats" => $result,
				"users" => $result2,
				"orders" => $result3,
				"productsCount" => $productsCount,
				//				
			]; 
		}

		// add prod
		public function addProdAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// AddProd form, with @param Doctrine\ORM\EntityManager used for ObjectSelect Cats Entity
			$form = new AddProd($manager); 
			// r
			$prod = new Products; 
			// 
			$form->setHydrator(new DoctrineHydrator($manager,"Application\Entity\Products")); 
			$filter = $form->setInputFilter(new ProductFilter); 
			$form->bind($prod); 

			$request = $this->getRequest(); 
			if($request->isPost()):
				$data = $request->getPost(); 
				$files = $request->getFiles(); 
				$data->picture = $files->picture; 
				$data->otherPics = $files->otherPics; 
				$form->setData($data); 

				if($form->isValid()):
					// resize main img 
					if($data->picture):
						// filename
						$pos =  strpos($form->getData()->getPicture()["tmp_name"], "php"); 
						$filename =  substr($form->getData()->getPicture()["tmp_name"], $pos); 

						$imagine = new \Imagine\Gd\Imagine();
						$size    = new \Imagine\Image\Box(270,270);
						$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET; 
						$image = $imagine->open("public/img/products/{$filename}"); 
						$image
							->thumbnail($size,$mode)
							->save("public/img/products/small/".$filename); 
						
						// set string main pict name 
						$prod->setPicture($filename); 
					endif; 

					// resize other pics
					if($form->getData()->getOtherPics()):
						if(is_array($form->getData()->getOtherPics())): 
							// otherPics json
							$otherPics = []; 
							foreach($form->getData()->getOtherPics() as $key => $value): 
								// filename
								$pos =  strpos($value["tmp_name"], "php"); 
								$filename =  substr($value["tmp_name"], $pos); 
								$otherPics[] = $filename; 
								$imagine = new \Imagine\Gd\Imagine();
								$size    = new \Imagine\Image\Box(270,270);
								$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND; 
								$image = $imagine->open("public/img/products/{$filename}"); 
								$image
									->thumbnail($size,$mode)
									->save("public/img/products/small/".$filename); 
							endforeach; 
							
							if(is_array($otherPics)) if(isset($otherPics[0])) $prod->setOtherPics(json_encode($otherPics)); 
							
						endif; 
					endif; 

					// when evth is ok
					$manager->persist($prod); 
					$manager->flush(); 
					echo json_encode(["status" => "ok"]); 

				else: 
					echo json_encode($form->getMessages()); 
				endif; 

				exit(); 
			endif; 

			return [
				"form" => $form,
				//
			]; 
		}

		// edit product
		public function editProdAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// get prod id
			$id = ceil($this->params()->fromRoute("id")); 
			// if no id provided, 
			if(!$id): 
				// select and return all prods
				$query = $manager->createQuery(" SELECT u FROM Application\Entity\Products u "); 
				$result = $query->getResult(); 

				$viewModel = new ViewModel([
					"products" => $result,
					//
					]); 
				return $viewModel->setTemplate("main/admin/edit"); 
			endif;  

			/////////////////////////////////////////////////////////////

			// get prod repo by id
			$repo = $manager->getRepository("Application\Entity\Products")->findBy(["id" => $id]); 
			if(!isset($repo[0])):
				$view = new ViewModel(); 
				$view->setTemplate("main/admin/product-not-found"); 
				return $view; 
			endif; 

			// related to the product
			$form = new AddProd($manager);  
			$form->setHydrator(new DoctrineHydrator($manager,"Products")) 
				->setInputFilter(new ProductFilter)
				->bind($repo[0]); 

			// remove img or save changed 
			$request = $this->getRequest(); 
			if($request->isPost()):
				$data = $request->getPost(); 
				
				// remove img
				if($data->remove == 1):
					// if it's main pic
					if($repo[0]->getPicture()): 
						if($repo[0]->getPicture() == $data->img): 
							// check if img exist
							if(file_get_contents("public/img/products/{$data->img}")){
								// remove big img
								$bool = unlink("public/img/products/{$data->img}"); 
								// check if exist small img
								if(file_get_contents("public/img/products/small/{$data->img}")){
									$bool2 = unlink("public/img/products/small/{$data->img}"); 
								}
							}
							// save as json
							$repo[0]->setPicture(null); 
							// echo $repo[0]->getOtherPics(); exit(); 
							$manager->persist($repo[0]); 
							$manager->flush(); 
							// successfully removed
							if(isset($bool) && isset($bool2)) echo json_encode(["status" => "ok","mainImg" => true]); 
							exit(); 
						endif; 
					endif; 
					// if other pics, other pics are kept as json string in repo
					if($repo[0]->getOtherPics()): 
					
						$array = json_decode($repo[0]->getOtherPics(),1); 
						foreach($array as $key => $value): 
							if($data->img == $value): 
								// check if img exist
								$bool = $bool2 = 0; 
								if(file_exists("public/img/products/{$data->img}")){
									// remove big img
									$bool = unlink("public/img/products/{$data->img}"); 
								}								
								// remove from array
								unset($array[$key]); 
								// check if exist small img
								if(file_exists("public/img/products/small/{$data->img}")){
									$bool2 = unlink("public/img/products/small/{$data->img}"); 
								}
								// save as json
								$repo[0]->setOtherPics(json_encode($array)); 
								// else $repo[0]->setOtherPics(null); 

								$manager->persist($repo[0]); 
								$manager->flush(); 

								// successfully removed
								if($bool || $bool2) echo json_encode(["status" => "ok"]); 
								exit(); 
							endif; 
						endforeach; 
					exit(); 
					endif; 
				endif; 

				// save changes
				$files = $request->getFiles(); 
				$data->picture = $files->picture; 
				$data->otherPics = $files->otherPics; 
				$form->setData($data); 

				// get main picture and save in var, as if empty form main picture submits without img, will cause error
				if($repo[0]->getPicture()) $mainPicture = $repo[0]->getPicture(); 
				if(!isset($mainPicture)) $mainPicture = null; 
				
				// get otherPictures as json string
				if($repo[0]->getOtherPics()){
					// other pictures array
					$opa = json_decode($repo[0]->getOtherPics()); 
				}
				if(!isset($opa)) $opa = null; 
				if($form->isValid()): 
					// check if main picture wasnt uploaded, set it's previous picture
					if(!$repo[0]->getPicture()["name"]){
						if($mainPicture) $repo[0]->setPicture($mainPicture); 
						else $repo[0]->setPicture(null); 
					}
					
					// resize main img 
					if($data->picture): 
						if($data->picture["name"]): 

							// filename
							$pos =  strpos($form->getData()->getPicture()["tmp_name"], "php"); 
							$filename =  substr($form->getData()->getPicture()["tmp_name"], $pos); 
							
							// echo $pos."/".$filename.$form->getData()->getPicture()["tmp_name"]; exit(); 
							$imagine = new \Imagine\Gd\Imagine();
							$size    = new \Imagine\Image\Box(270,270);
							$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET; 
							
							$image = $imagine->open("public/img/products/{$filename}"); 
							$image
								->thumbnail($size,$mode)
								->save("public/img/products/small/".$filename); 
							
							// set string main pict name 
							$repo[0]->setPicture($filename); 
						endif;  
					endif; 
					// resize other pics
					if($form->getData()->getOtherPics()):
						if(is_array($form->getData()->getOtherPics())): 
							// otherPics json
							$otherPics = []; 
							foreach($form->getData()->getOtherPics() as $key => $value): 
								// print_r($value); exit(); 
								if(!$value["name"]) continue; 
								// filename
								$pos =  strpos($value["tmp_name"], "php"); 
								$filename =  substr($value["tmp_name"], $pos); 
								$otherPics[] = $filename; 
								$imagine = new \Imagine\Gd\Imagine();
								$size    = new \Imagine\Image\Box(270,270);
								$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND; 
								// echo $filename; exit(); 
								$image = $imagine->open("public/img/products/{$filename}"); 
								$image
									->thumbnail($size,$mode)
									->save("public/img/products/small/".$filename); 
							endforeach; 

							// add into json string saved in db
							if(is_array($opa)){
								if(is_array($otherPics)){
									foreach ($otherPics as $key => $value) {
										array_push($opa, $value); 
									}
								}
							}
							else $opa = $otherPics; 
							
							$repo[0]->setOtherPics(json_encode($opa));
						endif; 
					endif; 

					// when evth is ok
					$manager->persist($repo[0]); 
					$manager->flush(); 
					echo json_encode(["status" => "ok"]); 
				else: 
					echo json_encode($form->getMessages()); 
				endif; 
				exit(); 

			endif; 
			

			return [
				"product" => $repo[0],
				"form" => $form,
				//
			]; 
		}

		// remove product

		public function removeProdAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// get prod id
			$id = ceil($this->params()->fromRoute("id")); 

			// determine what request it is, post or usual
			$request = $this->getRequest(); 
			if($request->isPost()): 
				// if no id provided
				if(!$id): 
					echo json_encode(["status" => "error", "error_description" => "no id was provided"]); 
					exit; 
				endif; 

				// get repository
				$repo = $manager->getRepository("Application\Entity\Products")->findBy(["id"=>$id]);
				if(!isset($repo[0])){
					echo json_encode(["status" => "error","nothing" => 1,"error description" => "nothing found by id"]); 
					exit; 
				}
				
				// remove imgs related to product if exist
					// check if img exist, remove if exists
				// main img
				$img = $repo[0]->getPicture();
				if(file_exists("public/img/products/{$img}")) unlink("public/img/products/{$img}");
				// other imgs
				if($repo[0]->getOtherPics()){
					// other pics are kept as JSON string
					$array = json_decode($repo[0]->getOtherPics());
					if(is_array($array)) if(!empty($array)){
						foreach($array as $key => $value):

							// remove img on by one
							if(file_exists("public/img/products/{$value}")) unlink("public/img/products/{$value}");

						endforeach;
					}
					
				}

				// echo $repo[0]->getPicture();
				// exit;

				// remove
				$manager->remove($repo[0]);
				$manager->flush();
				echo json_encode(["status"=>"ok"]);
				exit;
			endif; 
			
			// if no route id
			if(!$id) return $this->redirect()->toRoute("home"); 
		}

		//////////////////////////////////////////////////////////////////// RELATED TO CAT
		// add cat
		public function addCatAction()
		{			
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 


			$cat = new Cats; 
			$form = new AddCat($manager); 
			$form
				->setHydrator(new DoctrineHydrator($manager,"Cats"))
				->bind($cat)
				->setInputFilter(new AddCatFilter); 

			$request = $this->getRequest(); 
			if($request->isPost()): 
				$data = $request->getPost(); 
				$data->picture = $request->getFiles()["picture"]; 
				$form->setData($data); 
				if($form->isValid()):
					// resize main img 
					if($data->picture): 
						if($data->picture["name"]): 

							// filename
							$pos =  strpos($form->getData()->getPicture()["tmp_name"], "php"); 
							$filename =  substr($form->getData()->getPicture()["tmp_name"], $pos); 
							
							// echo $pos."/".$filename.$form->getData()->getPicture()["tmp_name"]; exit(); 
							$imagine = new \Imagine\Gd\Imagine();
							$size    = new \Imagine\Image\Box(270,270);
							$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET; 
							
							$image = $imagine->open("public/img/cats/{$filename}"); 
							$image
								->thumbnail($size,$mode)
								->save("public/img/cats/small/".$filename); 
							
							// set string main pict name 
							$cat->setPicture($filename); 

							$manager->persist($cat);
							$manager->flush();
							echo json_encode(["status" => "ok"]);
							exit;
						endif;  
					endif; 
				else:
					echo json_encode($form->getMessages());
				endif; 
				exit; 
			endif; 
				
			return [
				"form" => $form,
				//
			]; 
		}

		// edit category
		public function editCatAction()
		{
			// Doctrine\ORM\EntityManager
			$manager = $this->manager; 

			// category id
			$id = ceil($this->params()->fromRoute("id"));
			// get repo
			$repo = $manager->getRepository("Application\Entity\Cats")->findBy(["id"=>$id]);
			if(!isset($repo[0])){
				if($this->getRequest()->isPost()){
					echo json_encode(["status"=>"error","error"=>"no repo"]);
					exit;
				}
				else return $this->redirect()->toRoute("home");

			}						

			$form = new AddCat($manager);
			$form
				->setHydrator(new DoctrineHydrator($manager,"Cats"))
				->setInputFilter(new AddCatFilter);
			$form->bind($repo[0]);

			$request = $this->getRequest();
			if($request->isPost()):
				$data = $request->getPost();
				$data->picture = $request->getFiles()["picture"];
				$form->setData($data);
				if($form->isValid()):

					// resize main img 
					if($data->picture): 
						if($data->picture["name"]): 

							// filename
							$pos =  strpos($form->getData()->getPicture()["tmp_name"], "php"); 
							$filename =  substr($form->getData()->getPicture()["tmp_name"], $pos); 
							
							// echo $pos."/".$filename.$form->getData()->getPicture()["tmp_name"]; exit(); 
							$imagine = new \Imagine\Gd\Imagine();
							$size    = new \Imagine\Image\Box(270,270);
							$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET; 
							
							$image = $imagine->open("public/img/cats/{$filename}"); 
							$image
								->thumbnail($size,$mode)
								->save("public/img/cats/small/".$filename); 
							
							// set string main pict name 
							$repo[0]->setPicture($filename); 
							
							$manager->persist($repo[0]);
							$manager->flush();
							echo json_encode(["status" => "ok"]);
							exit;
						else:
							echo json_encode(["status"=>"error","error"=>"no picture"]);
							exit;
						endif; 
					endif;
				else:
					echo json_encode($form->getMessages());
					exit;

				endif; 
			endif;
			
			return [
				"form" => $form,
				"id"=>$repo[0]->getId()
			]; 
		}

		// remove category by AJAX request from /admin/
		public function removeCatAction()
		{
			// Doctrine\ORM\EntityManager

			$manager = $this->manager; 

			$request = $this->getRequest();
			if($request->isPost()):
				$data = $request->getPost();
				$catId = ceil($data->id);
				
				// get repository
				$repo = $manager->getRepository("Application\Entity\Cats")->findBy(["id"=>$catId]);
				if(!isset($repo[0])):
					echo json_encode(["status"=>"error","error"=>"no repo"]);
					exit;
				endif;
				
				// remove repo
				$manager->remove($repo[0]);
				$manager->flush();
				echo json_encode(["status"=>"ok"]);
				exit;
			endif; 

			// if no POST request, refer to main page
			return $this->redirect()->toRoute("home");
		}

	}