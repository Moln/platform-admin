<?php
/**
 * platform-admin RoleController.php
 *
 * @DateTime 13-4-26 下午5:18
 */

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
 * @author  Moln Xie
 * @version $Id: RoleController.php 1077 2013-07-03 07:47:44Z maomao $
 */
class RoleController extends AbstractActionController
{

    public function readAction()
    {
        return new JsonModel(RoleTable::getInstance()->select()->toArray());
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        $form = new RoleForm();
        $form->loadInputFilter();
        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            RoleTable::getInstance()->save($data);

            $this->getServiceLocator()->get('cache')->clearByTags(array('role')); //清除角色数据缓存
            return new JsonModel($data);
        } else {
            return new JsonModel(array('errors' => $form->getInputFilter()->getMessages()));
        }
    }

    public function deleteAction()
    {
        $roleId = $this->getRequest()->getPost('role_id');
        RoleTable::getInstance()->deletePrimary($roleId);
        AssignUserTable::getInstance()->removeRoleId($roleId);
        AssignPermissionTable::getInstance()->removeRoleId($roleId);

        $this->getServiceLocator()->get('cache')->clearByTags(array('role')); //清除角色数据缓存
        return new JsonModel(array());
    }

    public function assignPermissionAction()
    {
        $roleId      = $this->params('id');
        $assignTable = new AssignPermissionTable();
        $permissions = $assignTable->getPermissionsByRoleId($roleId);

        if ($this->getRequest()->isPost()) {
            $pushPermissions = $this->getRequest()->getPost('per_id');
            $assignTable->resetPermissionsByRoleId($roleId, $pushPermissions);

            $this->getServiceLocator()->get('cache')->clearByTags(array('role')); //清除角色数据缓存
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

            $this->getServiceLocator()->get('cache')->clearByTags(array('role')); //清除角色数据缓存
            return new JsonModel(array('code' => 1));
        }
        return array(
            'users' => $users,
        );
    }
}