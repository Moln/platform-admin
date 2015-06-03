<?php
namespace Moln\Admin\Controller;

use Moln\Admin\Form\RoleForm;
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

        $children = $this->get('Admin\RoleTable')->showChildren($roles, $children);

        return new JsonModel($children);
    }

    public function saveAction()
    {
        $parent = $this->getRequest()->getPost('parent');

        $roles = $this->identity()->getRoleIds();

        $flag = $this->get('Admin\RoleTable')->validChildren($roles, $parent);

        if (!$flag) return new JsonModel(array('errors' => "无权修改"));

        $data = $this->getRequest()->getPost();
        $form = new RoleForm();
        $form->loadInputFilter();
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            $this->get('Admin\RoleTable')->save($data);

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

        $flag = $this->get('Admin\RoleTable')->validChildren($roles, $parent);

        if (!$flag) return new JsonModel(array('errors' => "无权移动"));

        $this->get('Admin\RoleTable')->update(array("parent" => $parent), array('role_id' => $role_id));

        return new JsonModel(array('code' => 1));
    }

    public function deleteAction()
    {
        $datas = $this->getRequest()->getPost('data');

        foreach ($datas as $data) {
            $this->get('Admin\RoleTable')->deletePrimary($data);
            $this->get('AssignUserTable')->removeRoleId($data);
            $this->get('AssignPermissionTable')->removeRoleId($data);
        }
        return new JsonModel(array('code' => 1));
    }

    public function assignPermissionAction()
    {
        $roleId      = $this->params('id');
        $assignTable = $this->get('AssignPermissionTable');
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
        $assignTable = $this->get('AssignUserTable');
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
            'trees' => $this->get('Admin\RoleTable')->getTreesByRoleId(),
        );
    }
}