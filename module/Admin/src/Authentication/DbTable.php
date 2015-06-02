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
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class DbAdapter
 *
 * @package Admin\Authentication
 * @author  Xiemaomao
 * @version $Id$
 */
class DbTable extends CredentialTreatmentAdapter
    implements ServiceLocatorAwareInterface, AuthenticationAdapterInterface, ServiceManagerAwareInterface
{
    use ServiceLocatorAwareTrait;
    use AuthenticationAdapterServiceTrait;

    protected $dbAdapterName;

    public function __construct(array $options = [])
    {
        if (isset($options['db'])) {
            $this->dbAdapterName = $options['db'];
        }

        if (isset($options['table_name'])) {
            $this->setTableName($options['table_name']);
        }

        if (isset($options['identity_column'])) {
            $this->setIdentityColumn($options['identity_column']);
        }

        if (isset($options['credential_column'])) {
            $this->setCredentialColumn($options['credential_column']);
        }

        if (isset($options['credential_treatment'])) {
            $this->setCredentialTreatment($options['credential_treatment']);
        }
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $this->zendDb = $this->getServiceManager()->get($this->dbAdapterName);
        $result       = parent::authenticate();

        if ($result->isValid()) {
            var_dump($this->getUserIdentity());exit;
            $result = new Result($result->getCode(), $this->getUserIdentity(), $result->getMessages());
        }

        return $result;
    }

    public function getUserIdentity()
    {
        $identity = new UserIdentity();

        (new ClassMethods())->hydrate((array)$this->getResultRowObject(), $identity);

        return $identity;
    }
}