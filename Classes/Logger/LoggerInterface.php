<?php
/**
 * User: innerfly [v.sukhoff@gmail.com]
 * Date: 28.04.2018
 */

namespace Omshanti\Logger;

interface LoggerInterface
{
    public function log($message, $type = null);
}