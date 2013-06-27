<?php
/**
 * platform-admin ControllerAutoLoader.php
 * @DateTime 13-4-9 下午12:06
 */

namespace Core\Service;

/**
 * Class ControllerAutoLoader
 * @package System\Controller
 * @author Moln Xie
 * @version $Id: ControllerAutoLoader.php 885 2013-05-22 03:08:41Z maomao $
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