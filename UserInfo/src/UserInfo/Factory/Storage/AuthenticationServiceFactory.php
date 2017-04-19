<?php
/*
*class Objective for Authentication purpose. 
*/
namespace UserInfo\Factory\Storage;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\Storage\Session as SessionStorage;

class AuthenticationServiceFactory implements FactoryInterface {
	/**
	*function for authentication
	*@param servicelocator
	*@return authservice.
	*/
	public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter      
           = new DbTableAuthAdapter($dbAdapter, 'UserInfoTable','email','password', '');
        $storage = new SessionStorage();
		$authService = new AuthenticationService($storage, $dbTableAuthAdapter);
        return $authService;
    }
}

?>
