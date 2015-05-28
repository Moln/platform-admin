<?php

namespace Admin\Rbac;
use Gzfextra\Stdlib\OptionsTrait;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


/**
 * Class CacheTrait
 * @package Admin\Rbac
 * @author Xiemaomao
 * @version $Id$
 */
trait CacheTrait
{
    use ServiceLocatorAwareTrait;
    use OptionsTrait;
    protected $cache;

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @return \Zend\Cache\Storage\Adapter\AbstractAdapter
     */
    public function getCache()
    {
        return $this->getServiceManager()->get($this->cache);
    }

    /**
     * @param mixed $cache
     * @return $this
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }

    public function hasCache()
    {
        return $this->getServiceManager()->has($this->cache);
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getServiceLocator()->getServiceLocator();
    }

    /**
     * @return \Admin\Model\RoleTable
     */
    public function getRoleTable()
    {
        return $this->getServiceManager()->get('RoleTable');
    }
}