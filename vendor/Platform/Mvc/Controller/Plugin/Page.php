<?php
/**
 * platform-admin Paginator.php
 * @DateTime 13-5-15 下午3:55
 */

namespace Platform\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Paginator\Paginator;

/**
 * Class Paginator
 * @package Platform\Mvc\Controller\Plugin
 * @author Moln Xie
 * @version $Id$
 */
class Page extends AbstractPlugin
{

    public function __invoke(Paginator $paginator)
    {
        $paginator->setCurrentPageNumber($this->getParam('page', 1));
        $paginator->setDefaultItemCountPerPage($this->getParam('pageSize', 15));
    }

    private function getParam($name, $default = null)
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request    = $this->getController()->getRequest();
        $routeMatch = $this->getController()->getEvent()->getRouteMatch();
        return $request->getPost(
            $name, $routeMatch->getParam($name, $request->getQuery($name, $default))
        );
    }
}