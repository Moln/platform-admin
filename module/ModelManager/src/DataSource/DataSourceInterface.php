<?php


namespace Moln\ModelManager\DataSource;


interface DataSourceInterface {

    /**
     * 获取资源下的所有数据表
     * @return array
     */
    public function getTables();


    /**
     * @return \Zend\Paginator\Paginator
     */
    public function read();

    public function setDataConfig(array $config);
}