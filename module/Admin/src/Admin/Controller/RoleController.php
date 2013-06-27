<?php
/**
 * platform-admin RoleController.php
 * @DateTime 13-4-26 下午5:18
 */

namespace Admin\Controller;

use Admin\Form\RoleForm;
use Admin\Table\AssignPermissionTable;
use Admin\Table\AssignUserTable;
use Admin\Table\RoleTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class RoleController
 * @package Admin\Controller
 * @author Moln Xie
 * @version $Id: RoleController.php 1024 2013-06-26 09:05:39Z maomao $
 */
class RoleController extends AbstractActionController
{
    protected $roleTable;

    /**
     * @return RoleTable
     */
    public function getRoleTable()
    {
        if (!$this->roleTable) {
            $this->roleTable = new RoleTable();
        }
        return $this->roleTable;
    }

    public function readAction()
    {
        return new JsonModel($this->getRoleTable()->select()->toArray());
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $form = new RoleForm();
        $form->setTableGateway($this->getRoleTable());
        $form->loadInputFilter();
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            $this->getRoleTable()->save($data);
            return new JsonModel($data);
        } else {
            return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
        }
    }

    public function deleteAction()
    {
        $this->getRoleTable()->deletePrimary($this->getRequest()->getPost('user_id'));
        return new JsonModel(array());
    }

    public function assignPermissionAction()
    {
        $roleId       = $this->params('id');
        $assignTable  = new AssignPermissionTable();
        $permissions  = $assignTable->getPermissionsByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushPermissions = $this->getRequest()->getPost('per_id');
            $assignTable->resetPermissionsByRoleId($roleId, $pushPermissions);

            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'permissions' => $permissions,
        );
    }

    public function assignUserAction()
    {
        $roleId      = $this->params('id');
        $assignTable = new AssignUserTable();
        $users       = $assignTable->getUsersByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushUsers = $this->getRequest()->getPost('user_id');
            $assignTable->resetUsersByRoleId($roleId, $pushUsers);

            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'users' => $users,
        );
    }
}