<?php
namespace Admin\Model;

use Zend\Db\RowGateway\RowGateway;
use Zend\Permissions\Rbac\Rbac;

/**
 * Model User
 *
 * @property string $user_id
 * @property int $account
 * @property int $password
 * @property string $status
 * @property int $real_name
 * @property int $email
 *
 */
class User extends RowGateway
{

    protected $data = [
        'user_id'   => null,
        'account'   => null,
        'password'  => null,
        'status'    => null,
        'real_name' => null,
        'email'     => null,
    ];

    /**
     * @param string $user_id
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $account
     * @return self
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param int $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = UserTable::encrypt($password);
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $real_name
     * @return self
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param int $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getEmail()
    {
        return $this->email;
    }


    private $roles;
    private $roleIds;
    private $rbac;

    /**
     * Get user roles
     *
     * @return array
     */
    public function getRoles()
    {
        if (!$this->roles) {
            $this->roles = AssignUserTable::getInstance()->getRoleNamesByUserId($this->getUserId());
        }
        return $this->roles;
    }

    /**
     * Get user roleId
     *
     * @return array
     */
    public function getRoleIds()
    {
        if (!$this->roleIds) {
            $this->roleIds = AssignUserTable::getInstance()->getRoleIdsByUserId($this->getUserId());
        }
        return $this->roleIds;
    }

    public function __sleep()
    {
        return array('data', 'primaryKeyColumn', 'primaryKeyData');
    }

    public function __wakeup()
    {
        $this->table = UserTable::getInstance()->getTable();
        $this->sql   = UserTable::getInstance()->getSql();
        $this->initialize();
    }

    /**
     * @param $permission
     * @return Rbac
     */
    public function isAllow($permission)
    {
        if ($this->getUserId() == 1) return true;
        foreach ($this->getRoles() as $role) {
            if ($this->getRbac()->isGranted($role, $permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Rbac
     */
    public function getRbac()
    {
        return $this->rbac;
    }

    /**
     * @param Rbac $rbac
     * @return $this
     */
    public function setRbac(Rbac $rbac)
    {
        $this->rbac = $rbac;
        return $this;
    }
}