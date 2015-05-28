<?php
namespace Admin\Model;

use Gzfextra\Db\TableGateway\AbstractTableGateway;

/**
 * Class RoleTable
 *
 * @package Admin\Model
 * @author
 * @version $Id: RoleTable.php 728 2014-09-11 02:55:35Z Moln $
 *
 */
class RoleTable extends AbstractTableGateway
{
    protected $treeRoles;

    protected $permissions;

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
            array('module', 'controller', 'action')
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
                array('module', 'controller', 'action', 'permission')
            );
            $result = $this->selectWith($select);
            $result->setArrayObjectPrototype(new \ArrayObject());
            $this->permissions = $result->toArray();
        }

        return $this->permissions;
    }

    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function getTreeRole($childKey = 'items', callable $dataMapCallable = null)
    {
        $result = $this->select()->toArray();

        $dataMapCallable = $dataMapCallable ?: function ($row) {
            return array(
                'role_id'   => $row['role_id'],
                'text'      => $row['name'],
                'parent_id' => $row['parent'],
            );
        };

        return $this->toTreeData($result, $childKey, $dataMapCallable);
    }

    public function getTreeRoot()
    {
        return $this->getTreeRole()[0];
    }

    private function toTreeData($rows, $childKey = 'items', callable $dataMapCallable = null)
    {
        $rootId = 0;
        $data   = array($rootId => array($childKey => array()));
        foreach ($rows as $row) {
            if (!isset($data[$row['role_id']])) {
                $data[$row['role_id']] = $dataMapCallable($row);
            }

            $data[$row['parent']][$childKey][] = &$data[$row['role_id']];
        }

        return $data;
    }

    public function showChildren($roleIds)
    {
        $children = array();

        $select = $this->sql->select();
        $select->columns(array('role_id', 'name', 'parent'))->where(array('role_id' => $roleIds));

        $roles = $this->selectWith($select)->toArray();

        $this->getChildrenByRoles($roles, $children);

        return $children;

    }

    private function getChildrenByRoles($roles, & $array)
    {
        if (!is_array($roles)) return;

        foreach ($roles as $role) {

            $array[] = $role;

            $select = $this->sql->select();

            $select->columns(array('role_id', 'name', 'parent'))->where(array('parent' => $role['role_id']));

            $children = $this->selectWith($select)->toArray();

            if (is_array($children)) {

                $this->getChildrenByRoles($children, $array);
            }
        }
    }

    public function validChildren($roles, $targetNode)
    {

        $children = array();

        $children = $this->showChildren($roles, $children);

        $flag = false;

        foreach ($children as $child) {

            if ($child['role_id'] == $targetNode) {
                $flag = true;
                break;
            }
        }
        return $flag;

    }
}
