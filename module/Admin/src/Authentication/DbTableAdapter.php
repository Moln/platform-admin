<?php

namespace Admin\Authentication;

use Admin\Identity\UserIdentity;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\Db\Sql\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\Sql\Expression as SqlExpr;
use Zend\Db\Sql\Predicate\Operator as SqlOp;

/**
 * Class DbAdapter
 * @package Admin\Authentication
 * @author Xiemaomao
 * @version $Id$
 */
class DbTableAdapter extends AbstractAdapter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        /** @var \Admin\Model\UserTable $userTable */
        $userTable = $this->getServiceLocator()->get('Admin\UserTable');
        $user = $userTable->select(['account' => $this->getIdentity()])->current();

        if (!$user) {
            $code = Result::FAILURE_IDENTITY_NOT_FOUND;
            $identify = null;
        } else if ($user['password'] != $userTable::encrypt($this->getCredential())) {
            $code = Result::FAILURE_CREDENTIAL_INVALID;
            $identify = null;
        } else {
            $code = Result::SUCCESS;
            $identify = new UserIdentity();
        }

        return new Result(
            $code,
            $identify,
            []
        );
    }
}