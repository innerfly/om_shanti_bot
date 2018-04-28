<?php

require_once 'bootstrap.php';

//    $input = file_get_contents('php://input');

$deploy = new Omshanti\Deploy();
$deploy->execute();
echo nl2br($deploy->getMessages());

header("HTTP/1.1 200 OK");
exit;