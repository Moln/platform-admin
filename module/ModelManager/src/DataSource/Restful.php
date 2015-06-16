<?php

namespace Moln\ModelManager\DataSource;


/**
 * Class Restful
 *
 * @package Moln\ModelManager\DataSource
 * @author  Xiemaomao
 * @version $Id$
 */
class Restful implements DataSourceInterface
{

    /**
     * 获取资源下的所有数据表
     *
     * @return array
     */
    public function getTables()
    {
        // TODO: Implement getTables() method.
    }

    /**
     * @return \Zend\Paginator\Paginator
     */
    public function read()
    {
        // TODO: Implement read() method.
    }

    public function setDataConfig(array $config)
    {
        // TODO: Implement setDataConfig() method.
    }
}