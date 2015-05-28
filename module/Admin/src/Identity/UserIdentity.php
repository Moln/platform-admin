<?php

namespace Admin\Identity;

use ZfcRbac\Identity\IdentityInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


/**
 * Class UserIdentity
 * @author Xiemaomao
 * @version $Id$
 */
class UserIdentity implements IdentityInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $userId;
    protected $account;
    protected $password;
    protected $status;
    protected $realName;
    protected $email;

    /**
     * @param string $userId
     * @return self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
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
        $this->password = $password;
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
     * @param int $realName
     * @return self
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getRealName()
    {
        return $this->realName;
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

    /**
     * Get user roles
     *
     * @return array
     */
    public function getRoles()
    {
        if (!$this->roles) {
            $this->roles = $this->getServiceLocator()->get('AssignUserTable')->getRoleNamesByUserId($this->getUserId());
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
            $this->roleIds = $this->getServiceLocator()->get('AssignUserTable')->getRoleIdsByUserId($this->getUserId());
        }
        return $this->roleIds;
    }
}