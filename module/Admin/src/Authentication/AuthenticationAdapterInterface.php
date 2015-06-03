<?php
namespace Moln\Admin\Authentication;

interface AuthenticationAdapterInterface
{

    public function getCredential();
    public function setCredential($credential);

    public function getIdentity();
    public function setIdentity($identity);

    /**
     * @return \Moln\Admin\Identity\UserIdentity
     */
    public function getUserIdentity();
}