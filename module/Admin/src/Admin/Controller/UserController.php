<?php
/**
 * platform-admin UserController.php
 *
 * @DateTime 13-4-10 下午5:58
 */

namespace Admin\Controller;

use Admin\Form\UserForm;
use Admin\Model\AssignUserTable;
use Admin\Model\UserTable;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class UserController
 *
 * @package Admin\Controller
 * @author  Moln Xie
 * @version $Id: UserController.php 1077 2013-07-03 07:47:44Z maomao $
 */
class UserController extends AbstractActionController
{
    public function readAction()
    {
        $paginator = UserTable::getInstance()->fetchPaginator(
            function (Select $select) {
                $select->columns(array('user_id', 'account', 'real_name', 'email', 'status'));
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
        $data = $this->getRequest()->getPost();
        $form = new UserForm();
        $form->loadInputFilter(!empty($data['user_id']));
        $form->setData($data);

        if ($form->isValid()) {
            $data = $form->getData();
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = UserTable::encrypt($data['password']);
            }
            UserTable::getInstance()->save($data);
            unset($data['password']);
            return new JsonModel(array('data' => $data));
        } else {
            return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
        }
    }

    public function deleteAction()
    {
        $userId = $this->getRequest()->getPost('user_id');
        UserTable::getInstance()->deletePrimary($userId);
        AssignUserTable::getInstance()->removeUserId($userId);
        return new JsonModel(array());
    }

    public function assignAction()
    {
        $userId      = $this->params('id');
        $assignTable = AssignUserTable::getInstance();
        $roles       = $assignTable->getRolesByUserId($userId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetUsersById($userId, $pushRoles);
            return new JsonModel(
                array(
                     'code' => 1
                )
            );
        }
        return array(
            'roles' => $roles,
        );
    }
}
