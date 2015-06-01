<?php

namespace Admin\Authentication;
use Admin\Identity\UserIdentity;
use Zend\Authentication\Adapter\Ldap as ZendLdap;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcRbac\Identity\IdentityInterface;
use ZfcRbac\Identity\IdentityProviderInterface;


/**
 * Class LdapAdapter
 * @package Admin\Authentication
 * @author Xiemaomao
 * @version $Id$
 */
class Ldap extends ZendLdap implements AuthenticationAdapterInterface
{

    /**
     * @return IdentityInterface
     */
    public function getObjIdentity()
    {
        $identity = new UserIdentity();

        (new ClassMethods())->hydrate((array) $this->getAccountObject(), $identity);

        return $identity;
    }
}