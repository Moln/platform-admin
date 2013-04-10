<?php
return array(
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'system' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/system[/][:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'System\Controller',
                        'controller' => 'system',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'system' => __DIR__ . '/../view',
        ),
    ),
);
