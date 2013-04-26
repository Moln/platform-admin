<?php
/**
 * platform-admin AssignUserTable.php
 * @DateTime 13-4-18 下午3:37
 */
namespace System\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class AssignUserTable
 * @package System\Model
 * @author Xiemaomao
 * @version $Id$
 */
class AssignUserTable extends AbstractTableGateway
{

    protected $table = 'system_assign_user_role';

    public function __construct()
    {
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }

    public function getRolesByUserId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('role_id'));
        $select->where(array('user_id' => $id));

        $result = $this->selectWith($select);
        $roles = array();
        foreach ($result as $row) {
            $roles[] = (int)$row['role_id'];
        }
        return $roles;
    }

    public function getUsersByRoleId($id)
    {
        $select = $this->sql->select();
        $select->columns(array('user_id'));
        $select->where(array('role_id' => $id));

        $result = $this->selectWith($select);
        $users = array();
        foreach ($result as $row) {
            $users[] = (int)$row['user_id'];
        }
        return $users;
    }

    public function resetUsersById($userId, array $roles)
    {
        $this->delete(array('user_id' => $userId));
        foreach ($roles as $roleId) {
            $this->insert(array('role_id' => $roleId, 'user_id' => $userId));
        }
    }

    public function resetUsersByRoleId($roleId, array $users)
    {
        $this->delete(array('role_id' => $roleId));
        foreach ($users as $userId) {
            $this->insert(array('role_id' => $roleId, 'user_id' => $userId));
        }
    }
}