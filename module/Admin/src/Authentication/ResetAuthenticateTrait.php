<?php
namespace Admin\Authentication;

use Zend\Authentication\Result;

trait ResetAuthenticateTrait
{

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
            $result = new Result(
                $result->getCode(),
                $this->getObjIdentity(),
                $result->getMessages()
            );
        }

        return $result;
    }
}