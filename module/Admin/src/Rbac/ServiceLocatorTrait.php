<?php

namespace Moln\Admin\Rbac;
use Gzfextra\Stdlib\OptionsTrait;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


/**
 * Class CacheTrait
 * @package Admin\Rbac
 * @author Xiemaomao
 * @version $Id$
 */
trait ServiceLocatorTrait
{
    use ServiceLocatorAwareTrait;
    use OptionsTrait;
    protected $cache;

    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->getServiceLocator()->getServiceLocator();
    }

    /**
     * @return \Moln\Admin\Model\RoleTable
     */
    public function getRoleTable()
    {
        return $this->getServiceManager()->get('Admin\RoleTable');
    }
}