<?php
/**
 * platform-admin Permission.php
 * @DateTime 13-4-18 下午3:22
 */

namespace Admin\Controller;

use Admin\Table\AssignPermissionTable;
use Admin\Table\PermissionTable;
use Zend\Code\Reflection\FileReflection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class Permission
 * @package Admin\Controller
 * @author Moln Xie
 * @version $Id: PermissionController.php 1024 2013-06-26 09:05:39Z maomao $
 */
class PermissionController extends AbstractActionController
{
    protected $permissionTable;

    public function readAction()
    {
        return new JsonModel($this->getPermissionTable()->select()->toArray());
    }

    public function saveAction()
    {
        $id    = (int)$this->getRequest()->getPost('per_id');
        $title = $this->getRequest()->getPost('title');

        $this->getPermissionTable()->updateTitle($id, $title);
        return new JsonModel($this->getRequest()->getPost());
    }


    /**
     * 初始化权限
     */
    public function initAction()
    {
        $config = $this->getServiceLocator()->get('ApplicationConfig');

        $actions    = array();
        $modulePath = realpath(__DIR__ . '/../../../../');

        foreach ($config['modules'] as $module) {
            $pattern = $modulePath . "/$module/src/$module/Controller/*Controller.php";
            foreach (glob($pattern) as $file) {
                include_once $file;
                $ctrl       = basename($file, "Controller.php");
                $reflection = new FileReflection($file);
                $class      = $reflection->getClass();
                foreach ($class->getMethods() as $method) {
                    if ($method->getName() == 'getMethodFromAction'
                        || $method->getName() == 'notFoundAction'
                    ) {
                        continue;
                    }
                    if (substr($method->getName(), -6) == 'Action') {
                        $action = substr($method->getName(), 0, -6);
                        $module = $this->toRouteName($module);
                        $ctrl   = $this->toRouteName($ctrl);
                        $action = $this->toRouteName($action);

                        $title = $index = strtolower("$module.$ctrl.$action");
                        if ($method->getDocBlock()) {
                            $title = $method->getDocBlock()->getShortDescription();
                        }
                        $actions[$index] = array($module, $ctrl, $action, $title);
                    }
                }
            }
        }

        $perTable    = $this->getPermissionTable();
        $permissions = $perTable->select();

        foreach ($permissions as $row) {
            if (isset($actions["{$row['module']}.{$row['controller']}.{$row['action']}"])) {
                unset($actions["{$row['module']}.{$row['controller']}.{$row['action']}"]);
            } else {
                $row->delete();
            }
        }

        //添加新权限
        foreach ($actions as $row) {
            $perTable->insert(
                array(
                    'module'     => $row[0],
                    'controller' => $row[1],
                    'action'     => $row[2],
                    'title'      => $row[3],
                )
            );
        }
        return new JsonModel(array('code' => true));
    }

    private function toRouteName($name)
    {
        return strtolower(preg_replace('/[A-Z]/', '-$1', $name));
    }

    /**
     * 角色权限分配
     */
    public function assignAction()
    {
        $permissionId       = $this->params('id');
        $assignTable  = new AssignPermissionTable();
        $roles  = $assignTable->getRolesByPermissionId($permissionId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetPermissionsById($permissionId, $pushRoles);

            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'roles' => $roles,
        );
    }


    /**
     * @return PermissionTable;
     */
    public function getPermissionTable()
    {
        if (!$this->permissionTable) {
            $this->permissionTable = new PermissionTable;
        }
        return $this->permissionTable;
    }
}