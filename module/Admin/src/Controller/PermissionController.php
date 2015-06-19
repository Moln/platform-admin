<?php
namespace Moln\Admin\Controller;

use Moln\Admin\Module;
use Zend\Code\Reflection\FileReflection;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class Permission
 *
 * @package Admin\Controller
 */
class PermissionController extends AbstractActionController
{
    protected $permissionTable;

    /**
     * read
     *
     * @PermissionName index
     */
    public function readAction()
    {
        $results = $this->get('Admin\PermissionTable')->select(
            function (Select $select) {
                $select->where(['permission' => new Expression('concat(controller,"::",action)')]);
            }
        )->toArray();
        return new JsonModel($results);
    }

    /**
     * save
     *
     * @PermissionName index
     */
    public function saveAction()
    {
        $id    = (int)$this->getRequest()->getPost('per_id');
        $title = $this->getRequest()->getPost('title');

        $this->get('Admin\PermissionTable')->updateTitle($id, $title);
        return new JsonModel($this->getRequest()->getPost());
    }

    /**
     * 初始化权限
     *
     * @PermissionName index
     */
    public function initAction()
    {
        $dirs = (array)$this->get('config')[Module::CONFIG_KEY]['permission_scan_controller_dir'];

        $actions = array();
        foreach ($dirs as $module => $dir) {
            foreach (glob($dir . '/*Controller.php') as $file) {
                include_once $file;

                $ctrlName = basename($file, 'Controller.php');

                $reflection = new FileReflection($file);
                $class      = $reflection->getClass();
                foreach ($class->getMethods() as $method) {
                    if ($method->getName() == 'getMethodFromAction' || $method->getName() == 'notFoundAction') {
                        continue;
                    }
                    if (substr($method->getName(), -6) == 'Action') {
                        $action = substr($method->getName(), 0, -6);
                        $title  = $ctrlName . '.' . $action;

                        $permission = $index = $class->getName() . '::' . $action;
                        if ($method->getDocBlock()) {
                            $title = $method->getDocBlock()->getShortDescription();
                            if ($method->getDocBlock()->hasTag('PermissionName')) {
                                $permission = $method->getDocBlock()->getTag('PermissionName')->getContent();
                                if (!strpos($permission, '::')) {
                                    $permission = $class->getName() . '::' . $permission;
                                }
                            }
                        }

                        $actions[$index] = array($class->getName(), $module, $action, $permission, $title);
                    }
                }
            }
        }

        $perTable    = $this->get('Admin\PermissionTable');
        $permissions = $perTable->select();

        foreach ($permissions as $row) {
            $index = "{$row['controller']}::{$row['action']}";
            if (isset($actions[$index])) {
                $update = false;
                if ($row->title == $index && $row->title != $actions[$index][4]) {
                    $row->title = $actions[$index][4];
                    $update     = true;
                }
                if ($row->permission != $actions[$index][3]) {
                    $row->permission = $actions[$index][3];
                    $update          = true;
                }

                $update && $row->save();
                unset($actions[$index]);
            } else {
                $row->delete();
            }
        }

        //添加新权限
        foreach ($actions as $row) {
            $perTable->insert(
                array(
                    'controller' => $row[0],
                    'module'     => $row[1],
                    'action'     => $row[2],
                    'permission' => $row[3],
                    'title'      => $row[4],
                )
            );
        }
        $this->getEventManager()->trigger('permission.update');

        return new JsonModel(array('code' => true));
    }

    /**
     * 角色权限分配
     *
     * @PermissionName index
     */
    public function assignAction()
    {
        $permissionId = $this->params('id');
        $assignTable  = $this->get('Admin\AssignPermissionTable');
        $roles        = $assignTable->getRolesByPermissionId($permissionId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetPermissionsById($permissionId, $pushRoles);

            $this->getEventManager()->trigger('permission.update');
            return new JsonModel(
                array(
                    'code' => 1
                )
            );
        }
        return new ViewModel(
            [
                'roles' => $roles,
            ]
        );
    }
}