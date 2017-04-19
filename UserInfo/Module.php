<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UserInfo;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use UserInfo\Model\User;
use UserInfo\Model\UserInfoTable;
use UserInfo\Model\Role;
use UserInfo\Model\UserHasAsset;
use UserInfo\Model\UserHasRole;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


class Module  implements AutoloaderProviderInterface {
    
    public function onBootstrap(MvcEvent $e) {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() 
    {
            return array(
                'factories' =>array(
                    //For the UserInfoTable:-    
                    'UserInfo\Model\UserInfoTable' =>function($sm) {
                        $tableGateway = $sm->get('UserTableGateway');
                        $table =new UserInfoTable($tableGateway);
                        return $table;
                    },

                    'UserTableGateway' =>function($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype =new ResultSet();
                        $resultSetPrototype->
                        setArrayObjectPrototype(new User());
                        return new TableGateway('UserInfoTable', $dbAdapter,null, $resultSetPrototype);
                    },
                            
                    //For the Role Table
                    'UserInfo\Model\Role' =>function($sm) {
                        $tableGateway = $sm->get('RoleTableGateway');
                        $table =new Role($tableGateway);
                        return $table;
                    },

                    'RoleTableGateway' =>function($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype =new ResultSet();
                        return new TableGateway('RoleTable', $dbAdapter,null, $resultSetPrototype);
                    },

                    //For the UserHasAsset:-    
                    'UserInfo\Model\UserHasAsset' =>function($sm) {
                        $tableGateway = $sm->get('UserAssetTableGateway');
                        $table = new UserHasAsset($tableGateway);
                        return $table;
                    },
                    'UserAssetTableGateway' =>function($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype =new ResultSet();
                        return new TableGateway('userhasassetsTable', $dbAdapter,null, $resultSetPrototype);
                    },
                    //For the UserHas Role:-
                    'UserInfo\Model\UserHasRole' =>function($sm) {
                        $tableGateway = $sm->get('UserRoleTableGateway');
                        $table = new UserHasRole($tableGateway);
                        return $table;
                    },
                    'UserRoleTableGateway' =>function($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype =new ResultSet();
                        return new TableGateway('userHasRole', $dbAdapter,null, $resultSetPrototype);
                    },
                ),
            );

    }
}
?>