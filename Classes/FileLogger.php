<?php

namespace Omshanti;

class FileLogger implements LoggerInterface
{
    private $log_file;
    private $_messages = [];
    private $_date_format = 'Y-m-d H:i:s';

    public function __construct()
    {
        $this->log_file = ROOT_DIR . "/logs/deployments.log";
    }

    public function log($message, $type = 'info')
    {
        $source = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'webhook' : 'system';
        $row = date($this->_date_format) . " [$type][$source]: $message";
        $this->_messages[] = $row . PHP_EOL;

        $filename = $this->log_file;

        if (!file_exists($filename)) {
            file_put_contents($filename, PHP_EOL);
            chmod($filename, 0666);
        }

        file_put_contents($filename, $row . PHP_EOL, FILE_APPEND);
    }

    public function getMessages()
    {
        return $this->_messages;
    }

}