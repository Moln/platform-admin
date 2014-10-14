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
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPermissions()
    {
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
            array('module', 'controller', 'action')
        );
        $result = $this->selectWith($select);
        $result->setArrayObjectPrototype(new \ArrayObject());
        return $result;
    }

    public function getTreesByRoleId()
    {
        $select = $this->sql->select();
        $select->columns(array('role_id', 'name', 'parent'));

        $result = $this->selectWith($select)->toArray();

        return $this->toTreeData($result, 0);
    }

    public function showChildren($role_ids)
    {
        $children = array();

        $select = $this->sql->select();
        $select->columns(array('role_id', 'name', 'parent'))->where(array('role_id' => $role_ids));

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

    private function toTreeData($rows, $rootId)
    {
        $data = array($rootId => array('items' => array()));
        foreach ($rows as $row) {
            $data[$row['role_id']] = (isset($data[$row['role_id']]) ? $data[$row['role_id']] : array())
                + array(
                    'role_id'   => $row['role_id'],
                    'text'      => $row['name'],
                    'parent_id' => $row['parent'],
                );

            $data[$row['parent']]['items'][] = & $data[$row['role_id']];
        }

        return $data[$rootId]['items'];
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
