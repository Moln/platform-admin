<?php

namespace Admin\Controller;

use Admin\Form\LoginForm;
use Admin\Model\UserTable;
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
            $form = new LoginForm();
            $form->loadInputFilter();
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $formData    = $form->getData();
                $authAdapter = UserTable::getInstance()->getAuthAdapter(
                    $formData['account'], $formData['password']
                );
                /** @var \Zend\Authentication\AuthenticationService $auth */
                $auth = $this->getServiceLocator()->get('auth');
                $auth->setAdapter($authAdapter);

                $result = $auth->authenticate();
                if ($result->isValid()) {
                    $user = UserTable::getInstance()->create((array)$authAdapter->getResultRowObject());
                    $auth->getStorage()->write($user);
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
