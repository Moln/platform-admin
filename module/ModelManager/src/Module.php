<?php

namespace Moln\ModelManager;


/**
 * Class Module
 * @package Moln\ModelManager
 * @author Xiemaomao
 * @version $Id$
 */
class Module 
{
    const CONFIG_KEY = 'moln_model_manager';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}