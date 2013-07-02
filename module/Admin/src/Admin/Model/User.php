<?php
namespace Admin\Model;

use Zend\Db\RowGateway\RowGateway;

/**
 * User.php
 * @author Administrator
 * @DateTime 12-12-29 上午11:43
 * @version $Id: User.php 1024 2013-06-26 09:05:39Z maomao $
 *
 * @property $user_id
 * @property $account
 * @property $real_name
 * @property $email
 * @property $password
 * @property $status
 * @property UserTable $table
 */
class User extends RowGateway
{
    private $roles;

    /**
     * @param mixed $user_id
     *
     * @return User
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $account
     *
     * @return User
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $real_name
     *
     * @return User
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get user roles
     * @return array
     */
    public function getRoles()
    {
        if (!$this->roles) {
            $this->roles = AssignUserTable::getInstance()->getRoleNamesByUserId($this->getUserId());
        }
        return $this->roles;
    }
}
