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
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'System\Controller',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
                'child_routes'  => array(
                    'method' => array(
                        'type' => 'Wildcard',
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),

    'view_helpers' => array(
        'invokables' => array(
            'uri' => 'Platform\View\Helper\Uri',
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'system' => __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
    ),
);
