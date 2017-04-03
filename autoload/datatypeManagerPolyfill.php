<?php

use Adminaut\Datatype\DatatypeManager;
use Zend\ServiceManager\ServiceManager;

call_user_func(function () {
    $target = method_exists(ServiceManager::class, 'configure')
        ? DatatypeManager\DatatypeManagerV2Polyfill::class // TODO[petrm] V3
        : DatatypeManager\DatatypeManagerV2Polyfill::class;

    class_alias($target, DatatypeManager::class);
});
