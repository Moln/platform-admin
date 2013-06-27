<?php
/**
 * platform-admin Uri.php
 * @DateTime 13-4-26 下午4:37
 */

namespace Platform\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Uri
 * @package Platform\View\Helper
 * @author Moln Xie
 * @version $Id: Uri.php 885 2013-05-22 03:08:41Z maomao $
 */
class Uri extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    public function __invoke()
    {
        return $this->serviceLocator->getServiceLocator()->get('request')->getUri();
    }
}