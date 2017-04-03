<?php

namespace Adminaut\Datatype;

/**
 * Class Module
 * @package Adminaut\Datatype
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        var_dump('BEDI');
        return include __DIR__ . '/../config/module.config.php';
    }
}
