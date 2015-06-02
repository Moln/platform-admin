<?php
/**
 * 
 * User: xiemaomao
 * Date: 2015/6/1
 * Time: 18:29
 */

namespace Admin\Authentication;



interface AuthenticationAdapterInterface
{

    public function getCredential();
    public function setCredential($credential);

    public function getIdentity();
    public function setIdentity($identity);

    /**
     * @return \Admin\Identity\UserIdentity
     */
    public function getUserIdentity();
}