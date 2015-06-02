<?php

namespace Admin\Authentication;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;


/**
 * AuthenticationAdapterPluginManager
 *
 * @package Admin\Authentication
 * @author  Xiemaomao
 * @version $Id$
 */
class AuthenticationAdapterPluginManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $invokableClasses = array(
        'dbtable' => 'Admin\Authentication\DbTable',
        'ldap'    => 'Admin\Authentication\Ldap',
    );

    /**
     * Validate the plugin
     *
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof AuthenticationAdapterInterface) {
            throw new \RuntimeException('Error authentication adapter "' . get_class($plugin) . '"');
        }
    }
}