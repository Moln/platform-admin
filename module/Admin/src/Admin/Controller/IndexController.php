<?php
namespace Admin\Controller;

use Admin\Form\SelfForm;
use Admin\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Version\Version;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function selfAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = new SelfForm();
            $form->loadInputFilter();
            $form->setData($_POST);
            if ($form->isValid()) {
                $data     = $form->getData();
                /** @var \Admin\Model\User $identity */
                $identity = $this->identity();
                if ($data['password']) {
                    $identity->setPassword($data['password']);
                }
                $identity->setRealName($data['real_name']);
                $identity->setEmail($data['email']);
                $identity->save();
                return new JsonModel(array('code' => 1));
            } else {
                return new JsonModel(array(
                    'code'   => 0,
                    'errors' => $form->getInputFilter()->getMessages()
                ));
            }
        }

        (new ViewModel());

        return array();
    }
}
