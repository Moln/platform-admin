<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),

        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
    ),
    'file_storage' => array(
        'type' => 'fileSystem',
        'options' => array(
            'default_path' => realpath('./public/uploads'),
            'validators' => array(
                'Extension' => array('gif', 'jpg', 'jpeg', 'png'),
                'Size'      => array('max' => 1024 * 1024),
                'IsImage',
            ),
            'filters' => array(
                'LowerCaseName',
                'RenameUpload' => array(
                    'target' => 'shop',
                    'use_upload_extension' => true,
                    'randomize' => true,
                ),
            ),
        ),
    ),

    'auth_module' => array(
        'admin',
//        'shop',
//        'payment',
    ),
    'service_manager' => array(
        'factories' => array(
            'FileStorage' => '\Platform\File\Storage\StorageFactory'
        )
    ),
);