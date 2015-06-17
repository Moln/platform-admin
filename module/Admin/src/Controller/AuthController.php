<?php

namespace Moln\Admin\Controller;

use Moln\Admin\InputFilter\LoginInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
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
        if ($this->getRequest()->isPost()) {
            /** @var \Moln\Admin\Model\UserTable $userTable */
            $form = new LoginInputFilter();
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $formData    = $form->getValues();

                /**
                 * @var \Zend\Authentication\AuthenticationService $auth
                 * @var \Moln\Admin\Authentication\AuthenticationAdapterInterface $adapter
                 */
                $auth = $this->get('Moln\Admin\AuthenticationService');
                $adapter = $auth->getAdapter();
                $adapter->setIdentity($formData['account']);
                $adapter->setCredential($formData['password']);

                $result = $auth->authenticate();
                if ($result->isValid()) {
                    $identity = $result->getIdentity();
                    $roles = $this->get('Admin\AssignUserTable')->getRoleNamesByUserId($identity->getUserId());
                    $identity->setRoles($roles);
                    $return = array('code' => 1);
                } else {
                    $return = array(
                        'code' => $result->getCode(),
                        'msg'  => current($result->getMessages())
                    );
                }
            } else {
                $return = array(
                    'code' => 0,
                    'msg'  => current(current($form->getMessages()))
                );
            }

            return new JsonModel($return);
        }

        $this->layout('layout/login');
    }

    public function logoutAction()
    {
        /** @var \Zend\Authentication\AuthenticationService $auth */
        $auth = $this->getServiceLocator()->get('auth');
        $auth->clearIdentity();

        return $this->redirect()->toRoute('login');
    }
}