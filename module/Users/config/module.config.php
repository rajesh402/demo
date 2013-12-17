<?php
//echo __DIR__."users";
return array(
       'router' => array(
        'routes' => array(

            'users' => array(
                'type'    => 'segment',
                'options' => array(
                    //'route'    => '/users[/:cont][/:action]',
                    'route'    => '/users[/:cont][/:action][/:id]',
                    'constraints' => array(
                        'cont' => '[a-zA-Z][a-zA-Z0-9_-]*',                       
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'                       
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'msg' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/users/msg[/:action]',
                    'constraints' => array(
                        'cont' => '[a-zA-Z][a-zA-Z0-9_-]*',                       
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'                       
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Msg',
                        'action'     => 'msg',
                    ),
                ),
            ),
            
             'fupload' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/users[/:cont][/:action][/:id]',
                    'constraints' => array(
                        'cont' => '[a-zA-Z][a-zA-Z0-9_-]*',                       
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'                       
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Fupload',
                        'action'     => 'fupload',
                    ),
                ),
            ),

            
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
            'Users\Controller\Msg' => 'Users\Controller\MsgController',
            'Users\Controller\Fupload' => 'Users\Controller\FuploadController'
        ),
    ),
    'view_manager' => array(

        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'users/index/index' => __DIR__ . '/../view/users/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
);
