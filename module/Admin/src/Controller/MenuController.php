<?php
namespace Moln\Admin\Controller;

use Moln\Admin\Model\MenuTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class MenuController
 *
 * @package Admin\Controller
 * @author  Moln
 */
class MenuController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
//        if ($request->isPost()) {
//            $form = new MenuForm();
//            $form->init();
//            $form->setData($request->getPost()->toArray());
//            if ($form->isValid()) {
//                $data = $form->getData();
//                print_r($data);exit;
//                $menuTab->save($data);
//                return new JsonModel(array('data' => $data));
//            } else {
//                return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
//            }
//        }


        return array(
            'menu' => MenuTable::getData()
        );
    }

    public function saveAction()
    {
        $data = json_decode($this->getRequest()->getPost('data'), true);
        MenuTable::update($data);
        return new JsonModel(array('code' => 1));
    }
}