<?php

return array(
    'view_manager'    => array(
        'template_map'        => array(
            'operation-log/list' => __DIR__ . '/../view/admin/operation-log/list.phtml',
        ),
    ),
    'tables' => array(
        'Admin\OperationLogTable'             => array(
            'table'     => 'admin_operation_log',
            'primary'   => 'id',
        ),
    ),
);