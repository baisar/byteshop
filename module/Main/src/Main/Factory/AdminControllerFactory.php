<?php
	namespace Main\Factory;

	use Interop\Container\ContainerInterface,
		Zend\ServiceManager\Factory\FactoryInterface,
		Main\Controller\AdminController; 

	/**
	* AdminControllerFactory
	*/
	
	class AdminControllerFactory implements FactoryInterface
	{
		
		public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
		{
			return new AdminController($container->get("Doctrine\ORM\EntityManager")); 	
		}
	}