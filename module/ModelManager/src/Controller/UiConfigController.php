<?php

namespace Moln\ModelManager\Controller;

use Moln\ModelManager\InputFilter\UiConfig\DbUiConfigInputFilter;
use Moln\ModelManager\InputFilter\UiConfigInputFilter;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


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

    public function readAction()
    {
        $table   = $this->getUiConfigTable();

        /** @var \Zend\Paginator\Paginator $paginator */
        $paginator = $table->fetchPaginator(
            function (Select $select) {
                $select->columns(['id', 'name', 'source']);
            }
        );
        $paginator->setCurrentPageNumber($this->getRequest()->getPost('page', 1));

        return [
            'total' => $paginator->getTotalItemCount(),
            'data'  => $paginator->getCurrentItems()->toArray(),
        ];
    }

    public function getTablesAction()
    {
        return json_decode('{"tables":{"chargelog":["id","account","pt","dt","pid"],"player":["account","pid","puid","type","username","passwd","idcard","blocktime","state","lastlogintime","lastlogouttime","errors","createtime","monthloginnum","phone"],"user":["id","fullName","email"]},"error":null}', 1);
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

    public function saveAction()
    {
        $filters = new UiConfigInputFilter();
        $filters->setData($_REQUEST);

        if (!$filters->isValid()) {
            return ['errors' => $filters->getMessages()];
        }

        $data = $filters->getValues();

        if ($data['source_adapter'] != 'Restful') {
            $filters2 = new DbUiConfigInputFilter();
            $filters2->setData($this->getRequest()->getPost('source_config'));
            if (!$filters2->isValid()) {
                return ['errors' => $filters2->getMessages()];
            }

            $data += ['source_config' => json_encode($filters2->getValues())];
        }
        unset($data['source_adapter']);

        $table = $this->get('ModelManager\UiConfigTable');
        $table->insert($data);

        return new JsonModel(['code' => 1]);
    }

    /**
     * @return \Moln\ModelManager\Model\UiConfigTable
     */
    public function getUiConfigTable()
    {
        return $this->get('ModelManager\UiConfigTable');
    }

}