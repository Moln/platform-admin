<?php

namespace Moln\ModelManager\Controller;

use Moln\ModelManager\InputFilter\DataSourceConfig\BaseConfigInputFilter;
use Moln\ModelManager\InputFilter\DataSourceConfig\DbInputFilter;
use Moln\ModelManager\InputFilter\DataSourceConfig\RestfulInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


/**
 * Class TableConfigController
 *
 * @package Moln\ModelManager\Controller
 * @author  Xiemaomao
 * @version $Id$
 */
class DataSourceConfigController extends AbstractActionController
{

    public function addAction()
    {

        $baseConfigFilters = new BaseConfigInputFilter();

        $baseConfigFilters->setData($_REQUEST);

        if (!$baseConfigFilters->isValid()) {
            return array('errors' => $baseConfigFilters->getMessages());
        }

        $data   = $baseConfigFilters->getValues();

        $filter2 = $data['adapter'] == 'Restful' ? new RestfulInputFilter() : new DbInputFilter();
        $filter2->setData($_REQUEST);
        if (!$filter2->isValid()) {
            return array('errors' => $filter2->getMessages());
        }

        $data += $filter2->getValues();

        $table  = $this->get('ModelManager\DataSourceConfigTable');
        $config = array(
            'name'    => $data['name'],
            'adapter' => $data['adapter'],
        );

        unset($data['name'], $data['adapter']);
        $config['adapter_options'] = json_encode(['driver_options' => $data]);
        $table->insert($config);

        return new JsonModel(['code' => 1]);
    }
}