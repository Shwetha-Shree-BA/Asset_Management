<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AssetManagement;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use AssetManagement\Model\Asset;
use AssetManagement\Model\AssetInfoTable;
use UserInfo\Model\UserInfoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\AuthenticationService;
use AssetManagement\Model\leased;
use AssetManagement\Model\leasedoutuserTable;
use AssetManagement\Model\AssetType;
use Zend\Session\Container;


class Module {
    /*
    *Based on the Indentity (Email), allowed to move into the Screens:-
    */
    public function onBootstrap(MvcEvent $e) {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $auth = new AuthenticationService();
        $authenticated = false;
        if ($auth->hasIdentity()) {
            $authenticated = true;
        }

        $container = new Container('user');
        
        $viewModel = $e->getViewModel();
        $viewModel->setVariable('authenticated', $authenticated);
        $viewModel->setVariable('role', $container->role);
        $viewModel->setVariable('userId',$container->userId);
        $viewModel->setVariable('leasedout',$container->leasedout);

    }

 
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }



    /*
    *Invoked internally when the getServicelocator() is invoked:- 
    *
    */
    public function getServiceConfig() 
    {
        return array(
            'factories' =>array(
                //Used for the AssetInfoTable:-(AssetInfoTable obj is created by Service manager.)
                'AssetManagement\Model\AssetInfoTable' =>function($sm) {
                    $tableGateway = $sm->get('AssetTableGateway');
                    $table =new AssetInfoTable($tableGateway);
                    return $table;
                },

                'AssetTableGateway' =>function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype =new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Asset());
                    return new TableGateway('AssetInfoTable', $dbAdapter,null, $resultSetPrototype);
                },
                //Used for the AssetType:-(AssetType obj is created by service manager.)
                'AssetManagement\Model\AssetType' =>function($sm) {
                    $tableGateway = $sm->get('AssetTypeGateway');
                    $table =new AssetType($tableGateway);
                    return $table;
                },

                'AssetTypeGateway' =>function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype =new ResultSet();
                    return new TableGateway('AssetType', $dbAdapter,null, $resultSetPrototype);
                },

                //Used for leasedoutUserTable:- (obj is created service manager.) 
                'AssetManagement\Model\leasedoutuserTable' =>function($sm) {
                    $tableGateway = $sm->get('leasedoutGateway');
                    $table =new leasedoutuserTable($tableGateway);
                    return $table;
                },
                'leasedoutGateway' =>function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype =new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new 
                                leased());
                    return new TableGateway('leasedoutuserTable', $dbAdapter,null, $resultSetPrototype);
                },

                ),
            );
    }
}
?>
