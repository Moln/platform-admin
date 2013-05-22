<?php
/**
 * platform-admin Result.php
 * @DateTime 13-5-20 下午4:33
 */

namespace Platform\Mvc\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\JsonModel;

/**
 * Class Result
 * @package Platform\Mvc\Controller\Plugin
 * @author Moln Xie
 * @version $Id$
 */
class Result extends AbstractPlugin
{

    public function __invoke($message, $code = 1, $more = array())
    {
        if ($message) {
            $more['msg'] = $message;
        }

        return new JsonModel(array('code' => $code) + $more);
    }
}