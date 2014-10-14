<?php

namespace Product\Controller;

use Product\InputFilter\ProductInputFilter;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


/**
 * Class IndexController
 *
 * @package Product\Controller
 *
 * @method \Gzfextra\Mvc\Controller\Plugin\Ui ui();
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {

    }

    public function readAction()
    {
        $paginator = $this->getProductTable()->fetchPaginator(
            function (Select $select) {
                $select->where($this->ui()->filter());
                $select->order($this->ui()->sort() + ['id' => 'desc']);
            }
        );

        $paginator->setCurrentPageNumber($this->getRequest()->getPost('page', 1));
        return new JsonModel(
            array(
                'total' => $paginator->getTotalItemCount(),
                'data'  => $paginator->getCurrentItems()->toArray()
            )
        );
    }

    public function saveAction()
    {
        $inputFilter = new ProductInputFilter();
        $inputFilter->setData($_POST);

        if ($inputFilter->isValid()) {
            $data = $inputFilter->getValues();
            $this->getProductTable()->save($data);
            return new JsonModel(array('data' => $data));
        } else {
            return new JsonModel(array('errors' => $inputFilter->getMessages()));
        }
    }

    public function deleteAction()
    {
        $id = (int)$this->getRequest()->getPost('id');
        $this->getProductTable()->deletePrimary($id);
        return new JsonModel(array());
    }

    /**
     * @return \Product\Model\ProductTable
     */
    private function getProductTable()
    {
        return $this->getServiceLocator()->get('ProductTable');
    }
} 