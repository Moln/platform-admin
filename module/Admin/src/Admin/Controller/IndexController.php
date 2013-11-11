<?php
namespace Admin\Controller;

use Admin\Form\SelfForm;
use Admin\Model\AssignPermissionTable;
use Admin\Model\MenuTable;
use Admin\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Version\Version;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $menu = MenuTable::getData();

        /** @var \Admin\Model\User $user */
        $user = $this->identity();

        /** @var \Closure $menuFilter */
        $menuFilter = null;
        $menuFilter = function ($menu) use (&$menuFilter, $user) {
            foreach ($menu as $key => $item) {
                if (isset($item['permission'])) {
                    if (!$user->isAllow($item['permission'])) {
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

    public function selfAction()
    {

        if ($this->getRequest()->isPost()) {
            $form = new SelfForm();
            $form->loadInputFilter();
            $form->setData($_POST);
            if ($form->isValid()) {
                $data     = $form->getData();
                /** @var \Admin\Model\User $identity */
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

        (new ViewModel());

        return array();
    }
}
