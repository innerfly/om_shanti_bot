<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_DIR', __DIR__);

require ROOT_DIR . '/vendor/autoload.php';

$cfg = require_once 'config.php';
