<?php
	namespace Main\Factory;

	use Interop\Container\ContainerInterface,
		Zend\ServiceManager\Factory\FactoryInterface,
		Main\Controller\UserController; 

	/**
	* UserControllerFactory
	*/
	class UserControllerFactory implements FactoryInterface
	{
		
		public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
		{
	        $auth = $container->get("doctrine.authenticationservice.orm_default"); 
			return new UserController($container->get("Doctrine\ORM\EntityManager"),$auth); 	
		}
	}