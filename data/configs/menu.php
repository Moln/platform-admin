<?php
return array(
    0 => array(
        'text' => '系统',
        'index' => 0,
        'expanded' => true,
        'items' => array(
            0 => array(
                'text' => '用户管理',
                'index' => 0,
                'url' => './admin/user',
                'permission' => 'admin.user.index',
                'attributes' => '{"width":818}',
            ),
            1 => array(
                'text' => '角色管理',
                'index' => 1,
                'url' => './admin/role',
                'permission' => 'admin.role.index',
                'attributes' => '{"width":600}',
            ),
            2 => array(
                'text' => '权限管理',
                'index' => 2,
                'url' => './admin/permission',
                'permission' => 'admin.permission.index',
                'attributes' => '{"width":1096}',
            ),
            3 => array(
                'text' => '菜单管理',
                'index' => 3,
                'url' => './admin/menu',
                'permission' => 'admin.menu.index',
                'attributes' => '{"height":700}',
            ),
            4 => array(
                'text' => '个人信息',
                'index' => 4,
                'url' => './admin/index/self',
                'permission' => 'admin.index.self',
                'attributes' => '{"width":600}',
            ),
            5 => array(
                'text' => '角色关系',
                'index' => 5,
                'url' => './admin/role/trees',
                'permission' => 'admin.role.trees',
            ),
            6 => array(
                'text' => '操作日志',
                'index' => 6,
                'url' => './admin/operation-log/list',
                'permission' => 'admin.operation-log.list',
            ),
        ),
    ),
    1 => array(
        'text' => '产品管理',
        'index' => 1,
        'expanded' => true,
        'items' => array(
            0 => array(
                'text' => '产品管理',
                'index' => 0,
                'url' => './product',
                'permission' => 'product.index.index',
            ),
        ),
    ),
);
