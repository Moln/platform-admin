<?php

namespace Moln\ModelManager\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Class IndexController
 * @package Moln\ModelManager\Controller
 * @author Xiemaomao
 * @version $Id$
 */
class IndexController extends AbstractActionController
{

    public function uiAction()
    {
        $view = new ViewModel();
        $view->setTemplate(sprintf('model-manager/%s/%s', $this->params('ctrl'), $this->params('name')));
        return $view;
    }
}