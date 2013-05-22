<?php
/**
 * platform-admin UserController.php
 * @DateTime 13-4-10 下午5:58
 */

namespace Admin\Controller;

use Admin\Form\UserForm;
use Admin\Model\AssignUserTable;
use Admin\Model\User;
use Admin\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class UserController
 * @package Admin\Controller
 * @author Moln Xie
 * @version $Id$
 */
class UserController extends AbstractActionController
{
    protected $userTable;

    public function readAction()
    {
//        return new JsonModel($this->getUserTable()->fetchAll());
        $paginator = $this->getUserTable()->fetchPaginator();
        return new JsonModel(array(
            'total' => $paginator->getTotalItemCount(),
            'data'  => $paginator->getCurrentItems()->toArray()
        ));
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $form = new UserForm();
        $form->setTableGateway($this->getUserTable());
        $form->loadInputFilter(!empty($data['user_id']));
        $form->setData($data);

        if ($form->isValid()) {
            $userModel = new User($form->getData());
            $this->getUserTable()->save($userModel);
            unset($userModel['password']);
            return new JsonModel(array('data' => $userModel));
        } else {
            return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
        }
    }

    public function deleteAction()
    {
        $this->getUserTable()->deleteKey($this->getRequest()->getPost('user_id'));
        return new JsonModel(array());
    }

    public function assignAction()
    {
        $userId      = $this->params('id');
        $assignTable = new AssignUserTable();
        $roles       = $assignTable->getRolesByUserId($userId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetUsersById($userId, $pushRoles);
            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'roles' => $roles,
        );
    }


    /**
     * @return \Admin\Model\UserTable;
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $this->userTable = new UserTable();
        }
        return $this->userTable;
    }
}
