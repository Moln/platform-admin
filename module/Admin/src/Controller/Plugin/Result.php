<?php

namespace Moln\Admin\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\JsonModel;


/**
 * Class Result
 * @package Admin\Controller\Plugin
 * @author Xiemaomao
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