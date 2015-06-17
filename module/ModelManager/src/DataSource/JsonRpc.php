<?php

namespace Moln\ModelManager\DataSource;
use Gzfextra\Stdlib\OptionsTrait;


/**
 * Class JsonRpc
 * @package Moln\ModelManager\DataSource
 * @author Xiemaomao
 * @version $Id$
 */
class JsonRpc implements DataSourceInterface
{
    use OptionsTrait;

    protected $url, $fields = [];

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    /**
     * 获取资源下的所有数据表
     *
     * @return array
     */
    public function getTables()
    {
        return ['restful' => $this->getFields()];
    }

    /**
     * @return \Zend\Paginator\Paginator
     */
    public function read()
    {
    }

    public function setDataConfig(array $config)
    {
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }
}