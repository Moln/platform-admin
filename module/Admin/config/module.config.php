<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
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
);