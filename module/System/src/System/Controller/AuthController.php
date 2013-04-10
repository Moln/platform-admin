<?php

namespace System\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 *
 * @method \Zend\Http\PhpEnvironment\Request getRequest()
 */
class AuthController extends AbstractActionController
{
    protected $userTable;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
//$this->getServiceLocator()->get('System\Model\UserTable');
        if ($this->getRequest()->isPost()) {
            ;
        }
        return (new ViewModel())->setTerminal(true);
    }


    public function getUserTable()
    {
        if (!$this->userTable) {
            $this->userTable = $this->getServiceLocator()->get('System\Model\UserTable');
        }
        return $this->userTable;
    }
}
