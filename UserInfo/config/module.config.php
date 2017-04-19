<?php

    /**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    
    'router' => array(
        'routes' => array(
            'register' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    =>'/user/register',
                    'defaults' => array(
                        'controller' => 'UserInfo\Controller\UserInfo',
                        'action'     => 'addo',
                    
                    ),
                ),
            ),
                'login' => array(
                'type' => 'Literal',
                'options' => array(
                'route' => '/user/login',
                'defaults' => array(
                'controller' => 'UserInfo\Controller\UserInfo',
                'action' => 'index',
                    ),
                ),
            ),

                'regsucess' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user/regsucess',
                    'defaults' => array(
                        '__NAMESPACE__' => 'UserInfo\Controller',
                        'controller'    => 'UserInfo\Controller\UserInfo',
                        'action'        => 'regsucess',
                    ),
                ),
                ),
                'select' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user/selectuser',
                    'defaults' => array(
                        '__NAMESPACE__' => 'UserInfo\Controller',
                        'controller'    => 'UserInfo\Controller\UserInfo',
                        'action'        => 'select',
                    ),
                ),
                ),
                'update' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/user/edit/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'UserInfo\Controller\UserInfo',
                    'action' => 'edit'
                ),
            ),
        ),
                'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'UserInfo\Controller',
                        'controller'    => 'UserInfo\Controller\UserInfo',
                        'action'        => 'logout',
                    ),
                ),
            ),
    ),
),
    
     'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'AuthService' => 
               'UserInfo\Factory\Storage\AuthenticationServiceFactory',
        ),
    ),

     'controllers' => array(
        'invokables' => array(
            'UserInfo\Controller\UserInfo' => 'UserInfo\Controller\UserInfoController',
            'UserInfo\Controller\Success' => 'UserInfo\Controller\SuccessController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'user_form_template'           => __DIR__ . '/../view/user-info/user/add.phtml',
        ),
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'UserInfo/UserInfo/index' => __DIR__ . '/../view/UserInfo/UserInfo/index.phtml',
          
        ),

        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
  
);

?>