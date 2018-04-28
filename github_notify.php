<?php

require_once 'bootstrap.php';

//    $input = file_get_contents('php://input');

$logger = new Omshanti\Logger\FileLogger();
$deploy = new Omshanti\Deploy($logger);
$deploy->execute();

header("HTTP/1.1 200 OK");

echo nl2br(implode(' ', $logger->getMessages()));

exit;