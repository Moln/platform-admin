<?php

namespace Moln\Admin\Authentication;

use Moln\Admin\Identity\UserIdentity;
use Zend\Authentication\Adapter\Ldap as ZendLdap;
use Zend\Authentication\Result;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcRbac\Identity\IdentityInterface;


/**
 * Class LdapAdapter
 * @package Admin\Authentication
 * @author Xiemaomao
 * @version $Id$
 */
class Ldap extends ZendLdap implements AuthenticationAdapterInterface
{
    use AuthenticationAdapterServiceTrait;


    public function findUser($account)
    {
        /** @var \Moln\Admin\Model\UserTable $userTable */
        $userTable = $this->getServiceManager()->get('UserTable');
        return $userTable->select(['account' => $account])->current();
    }

    /**
     * @return IdentityInterface
     */
    public function getUserIdentity()
    {
        $identity = new UserIdentity();

        if (!$user = $this->findUser($this->getIdentity())) {
            throw new \RuntimeException('User not found');
            //todo create
        }

        (new ClassMethods())->hydrate((array) $this->getAccountObject(), $identity);

        return $identity;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $result = parent::authenticate();
        if ($result->isValid()) {
            $result = new Result($result->getCode(), $this->getUserIdentity(), $result->getMessages());
        }

        return $result;
    }
}