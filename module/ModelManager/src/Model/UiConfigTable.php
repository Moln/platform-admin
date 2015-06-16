<?php

namespace Moln\ModelManager\Model;
use Zend\Db\TableGateway\TableGateway;


/**
 * Class UiConfigTable
 * @package Moln\ModelManager\Model
 * @author Xiemaomao
 * @version $Id$
 */
class UiConfigTable extends TableGateway
{

    public function loadConfig($id)
    {
        if (!$config = $this->select(['id' => $id])->current()) {
            throw new \RuntimeException('Not found config id: ' . $id);
        }

        return $this->parseConfig($config);
    }

    public function parseConfig($config)
    {
        $jsonColumns = [
            'column_enable',
            'column_alias',
            'ui_hidden',
            'ui_title',
            'ui_template',
            'ui_width',
            'ui_index',
            'ui_sortable',
            'ui_filterable',
            'ui_type',
        ];

        foreach ($jsonColumns as $name) {
            $config[$name] = json_decode($config[$name], true);
        }

        return $config;

    }
}