<?php

namespace Moln\ModelManager\DataSource;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

/**
 * Class DataSourceManager
 * @package Moln\ModelManager\DataSource
 * @author Xiemaomao
 * @version $Id$
 */
class DataSourceManager extends AbstractPluginManager
{
    protected $invokableClasses = [
        'mysql'   => 'Moln\ModelManager\DataSource\Mysql',
        'oracle'  => 'Moln\ModelManager\DataSource\Oracle',
        'ibmDB2'  => 'Moln\ModelManager\DataSource\IbmDB2',
        'sqlite'  => 'Moln\ModelManager\DataSource\Sqlite',
        'pgsql'   => 'Moln\ModelManager\DataSource\Pgsql',
        'sqlsrv'  => 'Moln\ModelManager\DataSource\Sqlsrv',
        'restful' => 'Moln\ModelManager\DataSource\Restful',
    ];

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
        if (!$plugin instanceof DataSourceInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Plugin of type %s is invalid; must implement %s\DataSourceInterface',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            ));
        }
    }
}