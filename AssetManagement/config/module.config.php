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
         
            'home1' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    =>'/asset/add',
                    'defaults' => array(
                        'controller' => 'AssetManagement\Controller\Asset',
                        'action'     => 'add',
                    
                    ),
                ),
            ),
        
                'new' => array(
                'type' => 'Literal',
                'options' => array(
                'route' => '/asset',
                'defaults' => array(
                'controller' => 'AssetManagement\Controller\Asset',
                'action' => 'index'
                    )
                )
            ),
          
            
                'UserView' => array(
                'type'    => 'segment',


                'options' => array(
                'route' => '/asset/view/:id[/]',

                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                
                'defaults' => array(
                'controller' => 'AssetManagement\Controller\Asset',
                'action' => 'view'
                    )
                )
            ),
                
                
                'leased' => array(
                'type'    => 'segment',
               // 'id'=>'id1',
                'options' => array(
                'route'    => '/asset/leased-view/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'AssetManagement\Controller\Asset',
                    'action' => 'leased-view'
                ),
            ),
        ),

             
 
                'leasedview' => array(
                'type' => 'Literal',
                'options' => array(
                'route' => '/asset/leased-fetch',
                'defaults' => array(
                'controller' => 'AssetManagement\Controller\Asset',
                'action' => 'leased-fetch'
                    )
                )
            ),


                'lrow' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/asset/leased-row/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'AssetManagement\Controller\Asset',
                    'action' => 'leased-row'
                ),
            ),
        ),



               'updateStatus' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/asset/updateAssetStatus/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'AssetManagement\Controller\Asset',
                    'action' => 'status'
                ),
            ),
        ),

                
                'leasedStatus' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/asset/updateReturnTime/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'AssetManagement\Controller\Asset',
                    'action' => 'leased-status'
                ),
            ),
        ),

                'delete' => array(
                'type' => 'Literal',
                'options' => array(
                'route' => '/asset/delete',
                'defaults' => array(
                'controller' => 'AssetManagement\Controller\Asset',
                'action' => 'delete'
                    )
                )
            ),
                'edit' => array(
                'type'    => 'segment',
                'options' => array(
                'route'    => '/asset/update/:id[/]',
                'constraints' => array(
                    'id'     => '[0-9]+',
                ),
                'defaults' => array(
                    'controller' => 'AssetManagement\Controller\Asset',
                    'action' => 'update'
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
    ),
  
    'controllers' => array(
        'invokables' => array(
            'AssetManagement\Controller\Asset' => 'AssetManagement\Controller\AssetController'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'asset_form_template'           => __DIR__ . '/../view/asset-management/asset/add.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
  
);


?>