<?php

namespace Admin\Authentication;

use Admin\Identity\UserIdentity;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
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
class DbTable extends CredentialTreatmentAdapter implements ServiceLocatorAwareInterface, AuthenticationAdapterInterface
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
        $result = parent::authenticate();
        if ($result->isValid()) {
            $result = new Result($result->getCode(), $this->convertIdentity(), $result->getMessages());
        }
    }

    protected function getConvertIdentity($identify)
    {
        // TODO: Implement getConvertIdentity() method.
    }
}