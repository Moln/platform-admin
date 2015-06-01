<?php

namespace Admin\Authentication;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;


/**
 * Reset
 * @package Admin\Authentication
 * @author Xiemaomao
 * @version $Id$
 */
class AuthenticationAdapterPluginManager extends AbstractPluginManager
{
    /**
     * @var array
     */
    protected $invokableClasses = array(
        ''
    );

    protected $factories = array();

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

    }
}