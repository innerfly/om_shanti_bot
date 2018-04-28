<?php

namespace Omshanti;

use Omshanti\Logger\LoggerInterface;

class Deploy
{
    private $logger;
    private $branch;
    private $remote = 'origin';
    private $_is_production;
    private $post_deploy;
    protected $_data;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        // Environment
        $this->_is_production = true;

        // Branch
        $this->branch = $this->_is_production ? 'master' : 'develop';
    }

    public function execute()
    {
        try {
            $this->_deploy();

            if (is_callable($this->post_deploy)) {
                call_user_func($this->post_deploy, $this->_data);
            }

            $this->logger->log('Deployment end');
        }
        catch (\Exception $e) {
            $this->logger->log($e, 'error');
        }
    }

    private function _deploy()
    {
        $this->logger->log('Attempting deployment...');

        $this->_execute('cd ' . ROOT_DIR);
        $this->_execute('git reset --hard HEAD');
        $this->_execute('git pull ' . $this->remote . ' ' . $this->branch);
    }

    private function _execute($command)
    {
        $this->logger->log("Executing: '$command'");
        exec($command . ' 2>&1', $output, $return);
        $this->logger->log("Output: '" . implode(chr(0), $output) . "', Return: " . print_r(substr($return, 0, 500), true));
    }

}
