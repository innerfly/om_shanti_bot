<?php

require_once 'bootstrap.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($cfg['bot_api_key'], $cfg['bot_username']);

    // Set webhook
    $result = $telegram->setWebhook($cfg['hook_url'], ['certificate' => '/etc/nginx/ssl/PUBLIC.pem']);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    echo $e->getMessage();
}
