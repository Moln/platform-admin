<?php

namespace Moln\ModelManager\Controller;

use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;


/**
 * Class UiConfigController
 *
 * @package Moln\ModelManager\Controller
 * @author  Xiemaomao
 * @version $Id$
 */
class UiConfigController extends AbstractActionController
{
    public function initAction()
    {

        /** @var \Zend\Db\TableGateway\TableGateway $table */
        $table = $this->get('ModelManager\DataSourceConfigTable');

        $result = $table->select(
            function (Select $select) {
                $select->columns(['name', 'adapter']);
            }
        );

        return array(
            'data_source' => $result->toArray(),
        );
    }


    public function getTablesAction()
    {

        /** @var \Moln\ModelManager\DataSource\DataSourceManager $dataSourceManager */
        $dataSourceManager     = $this->get('Moln\ModelManager\DataSourceManager');
        $dataSourceConfigTable = $this->get('ModelManager\DataSourceConfigTable');
        $dataSourceConfig      = $dataSourceConfigTable->select(['name' => $this->params('name')])->current();

        $error = null;
        try {
            /** @var \Moln\ModelManager\DataSource\DataSourceInterface $dataSource */
            $dataSource = $dataSourceManager->get(
                $dataSourceConfig['adapter'],
                (array)json_decode($dataSourceConfig['adapter_options'], true)
            );

            $tables = $dataSource->getTables();
        } catch (\Exception $e) {
            $tables = [];
            $error  = $e->getMessage();
        }

        return array(
            'tables' => $tables,
            'error'  => $error
        );
    }

}