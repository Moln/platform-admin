<?php
namespace Moln\Admin\Controller;

use Moln\Admin\Form\SelfForm;
use Moln\Admin\Module;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
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
        $this->layout('layout/layout.admin.phtml');

        return array(
            'menu'     => $menu
        );
    }

    /**
     * 个人设置
     */
    public function selfAction()
    {

        if ($this->getRequest()->isPost()) {
            $form = new SelfForm();
            $form->loadInputFilter();
            $form->setData($_POST);
            if ($form->isValid()) {
                $data = $form->getData();
                /** @var \Moln\Admin\Model\User $identity */
                $identity = $this->identity();
                if ($data['password']) {
                    $identity->setPassword($data['password']);
                }
                $identity->setRealName($data['real_name']);
                $identity->setEmail($data['email']);
                $identity->save();
                return new JsonModel(array('code' => 1));
            } else {
                return new JsonModel(array(
                    'code'   => 0,
                    'errors' => $form->getInputFilter()->getMessages()
                ));
            }
        }

        return array();
    }
}
