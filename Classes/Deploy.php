<?php

namespace Omshanti;

class Deploy
{
    private $log_file;
    private $branch;
    private $directory;
    private $remote = 'origin';
    private $_messages = array();
    private $_date_format = 'Y-m-d H:i:s';
    private $_is_production;
    private $post_deploy;
    protected $_data;

    public function __construct($directory = null)
    {
        $this->log_file = ROOT_DIR . "/logs/deployments.log";

        // Environment
        $this->_is_production = true;

        // Branch
        $this->branch = $this->_is_production ? 'master' : 'develop';

        // Path
        $this->directory = realpath($directory) . DIRECTORY_SEPARATOR;
    }

    public function execute()
    {
        try {
            $this->_deploy();

            if (is_callable($this->post_deploy)) {
                call_user_func($this->post_deploy, $this->_data);
            }

            $this->log('Deployment end');
        } catch (Exception $e) {
            $this->log($e, 'ERROR');
        }
    }

    private function _deploy()
    {
        $this->log('Attempting deployment...');

        $this->_execute('cd ' . $this->directory);
        $this->_execute('git reset --hard HEAD');
        $this->_execute('git pull ' . $this->remote . ' ' . $this->branch);
    }

    private function _execute($command)
    {
        $this->log("Executing: '$command'");
        exec($command . ' 2>&1', $output, $return);
        $this->log("Output: '" . implode(chr(0), $output) . "', Return: " . print_r(substr($return, 0, 500), true));
    }

    public function log($message, $type = 'INFO')
    {
        $user = $_SERVER['REQUEST_METHOD'] === 'POST' ? 'webhook' : 'system';
        $row = date($this->_date_format) . '  [' . $user . '] ' . $type . ': ' . $message;
        $this->_messages[] = $row;

        if ($this->log_file) {
            $filename = $this->log_file;

            if (!file_exists($filename)) {
                file_put_contents($filename, "\r\n");
                chmod($filename, 0666);
            }

            file_put_contents($filename, $row . "\r\n", FILE_APPEND);
        }
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
    }

}
