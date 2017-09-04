<?php
	namespace Main\Factory;

	use Interop\Container\ContainerInterface,
		Zend\ServiceManager\Factory\FactoryInterface,
		Main\Controller\IndexController; 

	/**
	* IndexControllerFactory
	*/
	class IndexControllerFactory implements FactoryInterface
	{
		
		public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
		{
			return new IndexController($container->get("Doctrine\ORM\EntityManager")); 	
		}
	}