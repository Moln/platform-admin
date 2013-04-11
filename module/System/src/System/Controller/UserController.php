<?php
/**
 * platform-admin UserController.php
 * @DateTime 13-4-10 下午5:58
 */

namespace System\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package System\Controller
 * @author Xiemaomao
 * @version $Id$
 */
class UserController extends AbstractActionController
{
    protected $userTable;

    public function indexAction()
    {
    }

    public function readAction()
    {
        return new JsonModel(array(
            'total' => 77,
            'data' => $this->getUserTable()->fetchAll()->toArray()));
    }

    public function addAction()
    {
        echo 'add';
    }

    public function systemAction()
    {
        echo 'sdfsdf';
    }


    /**
     * @return \System\Model\UserTable;
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $this->userTable = $this->getServiceLocator()->get('UserTable');
        }
        return $this->userTable;
    }
}
