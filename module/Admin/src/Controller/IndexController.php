<?php
namespace Moln\Admin\Controller;

use Moln\Admin\Form\SelfForm;
use Moln\Admin\InputFilter\SelfInputFilter;
use Moln\Admin\Module;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout($this->get('config')[Module::CONFIG_KEY]['layout']);
    }

    public function initAction()
    {
        $menu = $this->getServiceLocator()->get('config')[Module::CONFIG_KEY]['menus'];

        /** @var \Moln\Admin\Identity\UserIdentity $user */
        $user = $this->identity();

        /** @var \Closure $menuFilter */
        $menuFilter = null;
        $menuFilter = function ($menu) use (&$menuFilter, $user) {
            foreach ($menu as $key => $item) {
                if (isset($item['permission'])) {
                    if (!$this->isGranted($item['permission'])) {
                        unset($menu[$key]);
                        continue;
                    }
                }
                if (isset($item['items'])) {
                    $menu[$key]['items'] = array_values($menuFilter($item['items'], $user));
                }
            }
            return $menu;
        };

        $menu = $menuFilter($menu);

        return array(
            'menu' => $menu
        );
    }

    public function uiAction()
    {
        $view = new ViewModel();
        $view->setTemplate(sprintf('moln/%s/%s', $this->params('ctrl'), $this->params('name')));
        return $view;
    }

    /**
     * 个人设置
     */
    public function selfAction()
    {
        if (!$this->getRequest()->isPost()) {
            return new JsonModel(array('code' => 1));
        }

        $filters = new SelfInputFilter();
        $filters->setData($_POST);
        if ($filters->isValid()) {
            $data = $filters->getValues();

            /** @var \Moln\Admin\Identity\UserIdentity $identity */
            $identity = $this->identity();
            if ($data['password']) {
                $identity->setPassword($data['password']);
            }

            $identity->setRealName($data['real_name']);
            $identity->setEmail($data['email']);

            $this->get('Admin\UserTable')->updateIdentity($identity);
            return new JsonModel(array('code' => 1));

        } else {
            return new JsonModel(
                array(
                    'code'   => 0,
                    'errors' => $filters->getMessages()
                )
            );
        }
    }
}
