<?php
namespace Admin\Controller;

use Admin\Model\AssignPermissionTable;
use Admin\Model\PermissionTable;
use Zend\Code\Reflection\FileReflection;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class Permission
 *
 * @package Admin\Controller
 */
class PermissionController extends AbstractActionController
{
    protected $permissionTable;

    public function readAction()
    {
        return new JsonModel(PermissionTable::getInstance()->select()->toArray());
    }

    public function saveAction()
    {
        $id    = (int)$this->getRequest()->getPost('per_id');
        $title = $this->getRequest()->getPost('title');

        PermissionTable::getInstance()->updateTitle($id, $title);
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

        $perTable    = PermissionTable::getInstance();
        $permissions = $perTable->select();

        foreach ($permissions as $row) {
            $index = "{$row['module']}.{$row['controller']}.{$row['action']}";
            if (isset($actions[$index])) {
                if ($row->title == $index && $row->title != $actions[$index][3]) {
                    $row->title = $actions[$index][3];
                    $row->save();
                }
                unset($actions[$index]);
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
        /** @var \Zend\Cache\Storage\Adapter\Filesystem $cache */
        $cache = $this->getServiceLocator()->get('cache');
        $cache->clearByTags(array('permission'));

        return new JsonModel(array('code' => true));
    }

    private function toRouteName($name)
    {
        return ltrim(strtolower(preg_replace('/([A-Z])/', '-$1', $name)), '-');
    }

    /**
     * 角色权限分配
     */
    public function assignAction()
    {
        $permissionId = $this->params('id');
        $assignTable  = AssignPermissionTable::getInstance();
        $roles        = $assignTable->getRolesByPermissionId($permissionId);

        if ($this->getRequest()->isPost()) {
            $pushRoles = $this->getRequest()->getPost('role_id');
            $assignTable->resetPermissionsById($permissionId, $pushRoles);

            $this->getServiceLocator()->get('cache')->clearByTags(array('permission'));
            return new JsonModel(array(
                'code' => 1
            ));
        }
        return array(
            'roles' => $roles,
        );
    }

    public function queryAction()
    {
        $url = $this->getRequest()->getPost('url');
        $url = parse_url($url);
        $url = $url['path'];
        $url = array_pad(explode('/', $url), 4, 'index');

        array_shift($url);
        list($module, $ctrl, $action) = $url;

        $per_id = PermissionTable::getInstance()->fetchByRule($module, $ctrl, $action);
        return new JsonModel(array('data' => implode('.', $url), 'code' => 1));
    }
}