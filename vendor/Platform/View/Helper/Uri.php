<?php
/**
 * platform-admin Uri.php
 * @DateTime 13-4-26 下午4:37
 */

namespace Platform\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

/**
 * Class Uri
 * @package Platform\View\Helper
 * @author Xiemaomao
 * @version $Id$
 */
class Uri extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var HelperPluginManager
     */
    protected $serviceLocator;

    public function __invoke()
    {
        return $this->serviceLocator->getServiceLocator()->get('request')->getUri();
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}