<?php
namespace Admin\Model;

use Zend\Db\RowGateway\AbstractRowGateway;

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
 */
class User extends AbstractRowGateway
{
    protected $inputFilter;
    protected $properties = array(
        'user_id'   => null,
        'account'   => null,
        'real_name' => null,
        'email'     => null,
        'password'  => null,
        'status'    => 0,
    );

    public function getUserId()
    {
        return $this['user_id'];
    }

    public function getAccount()
    {
        return $this['account'];
    }

    public function getEmail()
    {
        return $this['email'];
    }

    public function getPassword()
    {
        return $this['password'];
    }

    public function getStatus()
    {
        return $this['status'];
    }

    public function getRealName()
    {
        return $this['real_name'];
    }

    public function __construct($input = null)
    {
        if ($input) {
            $this->exchangeArray($input);
        }
    }
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function offsetSet($index, $value)
    {
        if (!array_key_exists($index, $this->properties)) {
            throw new \InvalidArgumentException('未知字段:' . $index);
        }

        $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $index)));
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            parent::offsetSet($index, $value);
        }
    }

    public function exchangeArray($data)
    {
        $data = array_intersect_key($data, $this->properties) + $this->properties;

        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    public function setPassword($value)
    {
        parent::offsetSet('password', $value ? md5($value) : null);
        return $this;
    }

    public function setRealName($realName)
    {
        parent::offsetSet('real_name', $realName);
    }

    public function setEmail($email)
    {
        parent::offsetSet('email', $email);
    }


    /**
     * Get user roles
     * @return array
     */
    public function getRoles()
    {
//        $select = $this->sql->select();
        return array();
    }
}
