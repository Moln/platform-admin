<?php
/**
 * platform-admin ControllerAutoLoader.php
 * @DateTime 13-4-9 下午12:06
 */

namespace Application\Service;

/**
 * Class ControllerAutoLoader
 * @package System\Controller
 * @author Moln Xie
 * @version $Id$
 */
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerAutoLoader implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        return class_exists($requestedName . 'Controller');
    }

    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $className = $requestedName . 'Controller';
        return new $className;
    }
}