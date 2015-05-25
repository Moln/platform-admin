<?php
return array(
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'platform_menus'           => array(
        array(
            'text'  => '产品管理',
            'items' => [
                ['text' => "产品列表", 'url' => "http://www.kendoui.com/"],
                ['text' => "产品添加"],
            ],
        ),
    ),

    'service_manager' => array(),
);