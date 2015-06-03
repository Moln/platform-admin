<?php
namespace Moln\Admin\Authentication;

use Zend\ServiceManager\ServiceManager;

trait AuthenticationAdapterServiceTrait
{

    protected $serviceManager;

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param ServiceManager $serviceManager
     * @return $this
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}