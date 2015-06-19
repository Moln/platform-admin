<?php
namespace Moln\Admin\Controller;

use Moln\Admin\InputFilter\UserInputFilter;
use Moln\Admin\Model\UserTable;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 *
 * @package Admin\Controller
 */
class UserController extends AbstractActionController
{
    public function readAction()
    {
        $userId    = $this->identity()->getUserId();
        $paginator = $this->get('Admin\UserTable')->fetchPaginator(
            function (Select $select) use ($userId) {
                $select->columns(array('user_id', 'account', 'real_name', 'email', 'status'));
                $select->where($this->ui()->filter());
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
        $form = new UserInputFilter(!empty($data['user_id']), $this->get('Admin\UserTable'));
        $form->setData($data);

        if ($form->isValid()) {
            $data = $form->getValues();
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = UserTable::encrypt($data['password']);
            }

            $data = new \ArrayObject($data);
            $this->getUserTable()->save($data);
            $data = (array)$this->getUserTable()->find($data['user_id']);
            if (isset($data['password'])) unset($data['password']);
            return new JsonModel(['data' => $data]);
        } else {
            return new JsonModel(array('errors' => $form->getMessages()));
        }
    }

    public function deleteAction()
    {
        $userId = $this->getRequest()->getPost('user_id');
        $this->get('Admin\UserTable')->deletePrimary($userId);
        $this->get('Admin\AssignUserTable')->removeUserId($userId);
        return new JsonModel(array());
    }

    public function assignAction()
    {
        $userId      = $this->params('id');
        if (!$userId) {
            $this->notFoundAction();
        }
        $assignTable = $this->getAssignUserTable();
        $roles       = $assignTable->getRolesByUserId($userId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetUsersById($userId, $pushRoles);
            return new JsonModel(['code' => 1]);
        }
        return new ViewModel(['roles' => $roles, 'user_id' => $userId]);
    }

    /**
     * @return \Moln\Admin\Model\UserTable
     */
    public function getUserTable()
    {
        return $this->get('Admin\UserTable');
    }

    /**
     * @return \Moln\Admin\Model\AssignUserTable
     */
    public function getAssignUserTable()
    {
        return $this->get('Admin\AssignUserTable');
    }
}
