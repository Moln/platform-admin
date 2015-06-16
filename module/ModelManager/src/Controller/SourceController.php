<?php

namespace Moln\ModelManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Class SourceController
 *
 * @package Moln\ModelManager\Controller
 * @author  Xiemaomao
 * @version $Id$
 */
class SourceController extends AbstractActionController
{

    public function viewAction()
    {
        if (!$id = $this->params('id')) {
            $this->notFoundAction();
        }

        $table = $this->getUiConfigTable();

        $config = $table->loadConfig($id);

        return new ViewModel(['id' => $id, 'config' => $config]);
    }

    public function readAction()
    {
        if (!$id = $this->params('id')) {
            $this->notFoundAction();
        }

        $config                = $this->getUiConfigTable()->loadConfig($id);
        $dataSourceManager     = $this->get('Moln\ModelManager\DataSourceManager');
        $dataSourceConfigTable = $this->get('ModelManager\DataSourceConfigTable');
        $dataSourceConfig      = $dataSourceConfigTable->select(['name' => $config['source']])->current();

        try {
            /** @var \Moln\ModelManager\DataSource\DataSourceInterface $dataSource */
            $dataSource = $dataSourceManager->get(
                $dataSourceConfig['adapter'],
                (array)json_decode($dataSourceConfig['adapter_options'], true)
            );

            $dataSource->setDataConfig((array)$config);
            $paginator = $dataSource->read($this->ui()->filter());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }

        return [
            'total' => $paginator->getTotalItemCount(),
            'data'  => (array) $paginator->getCurrentItems(),
        ];
    }

    /**
     * @return \Moln\ModelManager\Model\UiConfigTable
     */
    public function getUiConfigTable()
    {
        return $this->get('ModelManager\UiConfigTable');
    }
}