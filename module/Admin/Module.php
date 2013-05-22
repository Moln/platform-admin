<?php
namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $match = explode('/', trim($e->getRequest()->getRequestUri(), '/'));
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        if ($match[0] == strtolower(__NAMESPACE__)) {
            $auth = $sm->get('auth');
            if (!$auth->hasIdentity()) {
                header('Location: /login');
                exit;
            } else {
                $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
            }
        }
    }

    /**
     * @todo permission rbac
     * @param MvcEvent $e
     */
    public function onRoute(MvcEvent $e)
    {

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
