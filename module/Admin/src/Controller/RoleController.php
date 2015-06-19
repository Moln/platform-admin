<?php
namespace Moln\Admin\Controller;

use Moln\Admin\InputFilter\RoleInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class RoleController
 *
 * @package Admin\Controller
 */
class RoleController extends AbstractActionController
{

    /**
     * @return \Moln\Admin\Model\RoleTable
     */
    private function getRoleTable()
    {
        return $this->get('Admin\RoleTable');
    }

    public function readAction()
    {
        $roles = $this->getRoleTable()->getTreeRole()[0]['items'];
        $accessRoles = $this->get('Admin\AssignUserTable')->getRoleIdsByUserId($this->identity()->getUserId());

        return new JsonModel(['roles' => $roles, 'access_roles' => $accessRoles]);
    }

    public function addAction()
    {
        $roles     = $this->get('Admin\AssignUserTable')->getRoleIdsByUserId($this->identity()->getUserId());
        $roleTable = $this->getRoleTable();
        $filters   = new RoleInputFilter(true, $roles, $roleTable);
        $filters->setData($_REQUEST);

        if (!$filters->isValid()) {
            return new JsonModel(['errors' => $filters->getMessages()]);
        }

        $data = $filters->getValues();

        $roleTable->insert($data);
        $data['role_id'] = $roleTable->getLastInsertValue();

        return new JsonModel($data);
    }

    public function updateAction()
    {
        $roles     = $this->get('Admin\AssignUserTable')->getRoleIdsByUserId($this->identity()->getUserId());
        $roleTable = $this->getRoleTable();
        $filters   = new RoleInputFilter(false, $roles, $roleTable);
        $filters->setData($_REQUEST);

        if (!$filters->isValid()) {
            return new JsonModel(['errors' => $filters->getMessages()]);
        }

        $data = $filters->getValues();

        $this->getRoleTable()->update(
            ['parent' => $data['parent'], 'name' => $data['name']],
            ['role_id' => $data['role_id']]
        );

        return new JsonModel(array('code' => 1));
    }

    public function deleteAction()
    {
        $roles = $this->getRequest()->getPost('roles');

        foreach ($roles as $roleId) {
            $this->getRoleTable()->deletePrimary($roleId);
            $this->get('Admin\AssignUserTable')->removeRoleId($roleId);
            $this->get('Admin\AssignPermissionTable')->removeRoleId($roleId);
        }
        return new JsonModel(array('code' => 1));
    }

    public function assignPermissionAction()
    {
        $roleId      = $this->params('id');
        $assignTable = $this->get('Admin\AssignPermissionTable');
        $permissions = $assignTable->getPermissionsByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushPermissions = $this->getRequest()->getPost('per_id');
            if (!$pushPermissions) return new JsonModel(array('code' => -1, 'msg' => '更新失败'));
            $assignTable->resetPermissionsByRoleId($roleId, $pushPermissions);

            return new JsonModel(
                array(
                    'code' => 1
                )
            );
        }
        return new ViewModel([
            'role_id'     => $roleId,
            'permissions' => $permissions,
        ]);
    }

    public function assignUserAction()
    {
        $roleId      = $this->params('id');
        $assignTable = $this->get('Admin\AssignUserTable');
        $users       = $assignTable->getUsersByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushUsers = $this->getRequest()->getPost('user_id');

            if (!$pushUsers) return new JsonModel(array('code' => -1, 'msg' => '更新失败'));
            $assignTable->resetUsersByRoleId($roleId, $pushUsers);

            return new JsonModel(array('code' => 1));
        }
        return new ViewModel([
            'role_id' => $roleId,
            'users'   => $users,
        ]);
    }
}