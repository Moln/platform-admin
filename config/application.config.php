<?php
return array(
    'modules' => [
        'ZfcRbac',
        'Moln\Admin',
        'Product',
    ],

    'module_listener_options' => array(
        'module_paths' => array(
           './module',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local,' . (getenv('APPLICATION_ENV') ?: 'production'). '}.php',
        ),
    ),
);