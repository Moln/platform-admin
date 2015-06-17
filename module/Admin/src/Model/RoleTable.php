<?php
namespace Moln\Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class RoleTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: RoleTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class RoleTable extends TableGateway implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    protected $roles;
    protected $permissions;

    const CACHE_NAME = 'Cache\Moln\Admin\RoleTable';


    private function cache($callable, $key)
    {
        if ($this->getServiceLocator()->has(self::CACHE_NAME)) {
            /** @var \Zend\Cache\Storage\Adapter\AbstractAdapter $cache */
            $cache = $this->getServiceLocator()->get(self::CACHE_NAME);
            $result = $cache->getItem($key, $success);
            if (!$success) {
                $result = $callable();
                $cache->setItem($key, $result);
            }
            return $result;
        } else {
            return $callable();
        }
    }

    /**
     * 查询角色权限
     *
     * @param $role
     *
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPermissionsByRole($role)
    {
        $select = $this->sql->select();
        $select->columns(array());
        $select->join(
            'admin_assign_role_permission',
            'admin_role.role_id=admin_assign_role_permission.role_id',
            array()
        );
        $select->join(
            'admin_permission',
            'admin_assign_role_permission.per_id=admin_permission.per_id',
            array( 'controller', 'action')
        );

        $select->where(array('name' => $role));
        return $this->selectWith($select);
    }

    /**
     * 获取所有角色关联权限
     *
     * @return null|\Zend\Db\ResultSet\ResultSet
     */
    public function getPermissions()
    {
        if (empty($this->permissions)) {
            $this->permissions = $this->cache(function () {
                $select = $this->sql->select();
                $select->columns(array('name'));
                $select->join(
                    'admin_assign_role_permission',
                    'admin_role.role_id=admin_assign_role_permission.role_id',
                    array()
                );
                $select->join(
                    'admin_permission',
                    'admin_assign_role_permission.per_id=admin_permission.per_id',
                    array('controller', 'action', 'permission')
                );
                $result = $this->selectWith($select);
                $result->setArrayObjectPrototype(new \ArrayObject());
                return $result->toArray();
            }, __CLASS__ . '.' . __FUNCTION__);
        }

        return $this->permissions;
    }

    public function fetchAll()
    {
        if (!$this->roles) {
            $this->roles = $this->cache(function () {
                return $this->select()->toArray();
            }, __CLASS__ . '.' . __FUNCTION__);
        }

        return $this->roles;
    }

    public function getTreeRole($key = 'role_id', $childKey = 'items', callable $dataMapCallable = null)
    {
        $data = $this->fetchAll();

        $dataMapCallable = $dataMapCallable ?: function ($row, $data) {
            return $data + array(
                'role_id'   => $row['role_id'],
                'text'      => $row['name'],
                'parent_id' => $row['parent'],
            );
        };

        return $this->toTreeData($data, $key, $childKey, $dataMapCallable);
    }

    public function getTreeRoot()
    {
        return $this->getTreeRole()[0]['items'];
    }

    private function toTreeData($rows, $key = 'role_id', $childKey = 'items', callable $dataMapCallable = null)
    {
        $rootId = 0;
        $data   = array($rootId => array($childKey => array()));
        foreach ($rows as $row) {
            if (!isset($data[$row[$key]])) {
                $data[$row[$key]] = [];
            }
            $data[$row[$key]] = $dataMapCallable($row, $data[$row[$key]]);

            $data[$row['parent']][$childKey][] = &$data[$row[$key]];
        }

        return $data;
    }

    private function getRoleParents($roleId, &$parents = [])
    {
        $roles = $this->getTreeRole();

        if ($roles[$roleId]['parent_id']) {
            $parents[] = $roles[$roleId]['parent_id'];
            $this->getRoleParents($roles[$roleId]['parent_id'], $parents);
        }

        return $parents;
    }

    public function isValidParentAtRoles($parent, $accessRoles)
    {
        if (in_array($parent, $accessRoles)) {
            return true;
        }

        $parents = $this->getRoleParents($parent);

        return !empty(array_intersect($accessRoles, $parents));
    }
}