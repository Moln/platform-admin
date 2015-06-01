<?php

namespace Admin\Authentication;
use Zend\Authentication\Adapter\Ldap;
use ZfcRbac\Identity\IdentityProviderInterface;


/**
 * Class LdapAdapter
 * @package Admin\Authentication
 * @author Xiemaomao
 * @version $Id$
 */
class LdapAdapter extends Ldap implements IdentityProviderInterface
{

}