<?php
namespace Admin\Controller;

use Admin\Form\RoleForm;
use Admin\Model\AssignPermissionTable;
use Admin\Model\AssignUserTable;
use Admin\Model\RoleTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class RoleController
 *
 * @package Admin\Controller
 */
class RoleController extends AbstractActionController
{

    public function readAction()
    {
        $roles = $this->identity()->getRoleIds();

        $children = array();

        $children = RoleTable::getInstance()->showChildren($roles, $children);

        return new JsonModel($children);
    }

    public function saveAction()
    {
        $parent = $this->getRequest()->getPost('parent');

        $roles = $this->identity()->getRoleIds();

        $flag = RoleTable::getInstance()->validChildren($roles, $parent);

        if (!$flag) return new JsonModel(array('errors' => "无权修改"));

        $data = $this->getRequest()->getPost();
        $form = new RoleForm();
        $form->loadInputFilter();
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            RoleTable::getInstance()->save($data);

            return new JsonModel($data);
        } else {
            return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
        }
    }

    public function updateAction()
    {
        $parent  = $this->getRequest()->getPost('parent');
        $role_id = $this->getRequest()->getPost('role_id');

        $roles = $this->identity()->getRoleIds();

        $flag = RoleTable::getInstance()->validChildren($roles, $parent);

        if (!$flag) return new JsonModel(array('errors' => "无权移动"));

        RoleTable::getInstance()->update(array("parent" => $parent), array('role_id' => $role_id));

        return new JsonModel(array('code' => 1));
    }

    public function deleteAction()
    {
        $datas = $this->getRequest()->getPost('data');

        foreach ($datas as $data) {
            RoleTable::getInstance()->deletePrimary($data);
            AssignUserTable::getInstance()->removeRoleId($data);
            AssignPermissionTable::getInstance()->removeRoleId($data);
        }
        return new JsonModel(array('code' => 1));
    }

    public function assignPermissionAction()
    {
        $roleId      = $this->params('id');
        $assignTable = AssignPermissionTable::getInstance();
        $permissions = $assignTable->getPermissionsByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushPermissions = $this->getRequest()->getPost('per_id');
            if (!$pushPermissions) return new JsonModel(array('code' => -1, 'msg' => '更新失败'));
            $assignTable->resetPermissionsByRoleId($roleId, $pushPermissions);

            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'role_id'     => $roleId,
            'permissions' => $permissions,
        );
    }

    public function assignUserAction()
    {
        $roleId      = $this->params('id');
        $assignTable = AssignUserTable::getInstance();
        $users       = $assignTable->getUsersByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushUsers = $this->getRequest()->getPost('user_id');

            if (!$pushUsers) return new JsonModel(array('code' => -1, 'msg' => '更新失败'));
            $assignTable->resetUsersByRoleId($roleId, $pushUsers);

            return new JsonModel(array('code' => 1));
        }
        return array(
            'role_id' => $roleId,
            'users'   => $users,
        );
    }

    public function treesAction()
    {
        return array(
            'trees' => RoleTable::getInstance()->getTreesByRoleId(),
        );
    }
}