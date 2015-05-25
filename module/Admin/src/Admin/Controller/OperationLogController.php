<?php
namespace Admin\Controller;

use Admin\Model\OperationLogTable;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;


/**
 * Class OperationLogController
 *
 * @package Admin\Controller
 */
class OperationLogController extends AbstractActionController
{
    private $pageItem = 15;

    public function listAction()
    {

    }

    public function readAction()
    {
        $paginator = $this->get('OperationLogTable')->fetchPaginator(
            function (Select $select) {
                $select->columns(
                    array(
                        'id', 'uri', 'param', 'method', 'ip'=>new Expression("inet_ntoa(ip)"), 'time'
                    )
                )
                    ->join(
                        "admin_user", "admin_user.user_id = admin_operation_log.user_id", array(
                            'account'
                        ), 'left'
                    );
                $select->order(array('time' => 'desc'));
            }
        );
        $paginator->setCurrentPageNumber($this->getRequest()->getPost('page', 1));
        $paginator->setItemCountPerPage($this->pageItem);

        $data = $paginator->getCurrentItems()->toArray();

        return new JsonModel(
            array(
                'total' => $paginator->getTotalItemCount(),
                'data'  => $data,

            )
        );
    }
}