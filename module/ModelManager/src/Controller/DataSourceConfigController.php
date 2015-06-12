<?php

namespace Moln\ModelManager\Controller;

use Moln\ModelManager\InputFilter\DataSourceConfigInputFilter;
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

        $filters = new DataSourceConfigInputFilter();

        $filters->setData($_REQUEST);

        if (!$filters->isValid()) {
            return array('errors' => $filters->getMessages());
        }

        $data   = $filters->getValues();
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