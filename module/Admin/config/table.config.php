<?php
return array(
    'tables' => array(
        'Admin\ParamPermissionTable'  => array(
            'table'     => 'admin_param_permission',
            'invokable' => 'Admin\\Model\\ParamPermissionTable',
            'primary'   => array(),
        ),
        'Admin\AssignPermissionTable' => array(
            'table'     => 'admin_assign_role_permission',
            'invokable' => 'Admin\\Model\\AssignPermissionTable',
            'primary'   => 'role_id',
        ),
        'Admin\AssignUserTable'       => array(
            'table'     => 'admin_assign_user_role',
            'invokable' => 'Admin\\Model\\AssignUserTable',
            'primary'   => array(),
        ),
        'Admin\PermissionTable'       => array(
            'table'     => 'admin_permission',
            'invokable' => 'Admin\\Model\\PermissionTable',
            'row'       => true,
            'primary'   => 'per_id',
        ),
        'Admin\RoleTable'             => array(
            'table'     => 'admin_role',
            'invokable' => 'Admin\\Model\\RoleTable',
            'primary'   => 'role_id',
            'row'       => true,
        ),
        'Admin\UserTable'             => array(
            'table'     => 'admin_user',
            'invokable' => 'Admin\\Model\\UserTable',
            'row'       => 'Admin\\Model\\User',
            'primary'   => 'user_id',
        ),
        'Admin\OperationLogTable'             => array(
            'table'     => 'admin_operation_log',
            'invokable' => 'Admin\\Model\\OperationLogTable',
            'primary'   => 'id',
        ),
    ),
);
