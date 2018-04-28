<?php

require_once 'bootstrap.php';

//    $input = file_get_contents('php://input');

$deploy = new Omshanti\Deploy();
$deploy->execute();

header("HTTP/1.1 200 OK");

echo nl2br(implode(' ', $deploy->getMessages()));

exit;