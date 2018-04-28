<?php

use Longman\TelegramBot\Commands\SystemCommands\CallbackqueryCommand;
use Longman\TelegramBot\Entities\CallbackQuery;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use Longman\TelegramBot\Request;

require_once 'bootstrap.php';

try {
    // Create Telegram API object
    $telegram = new Telegram($cfg['bot_api_key'], $cfg['bot_username']);

    $commands_paths = [__DIR__ . '/Commands/',];
    // Add commands paths containing your custom commands
    $telegram->addCommandsPaths($commands_paths);
    // Enable admin users
    $telegram->enableAdmins($cfg['admin_users']);

    $telegram->setCommandConfig('weather', ['owm_api_key' => $cfg['weather_api_key']]);

    // Logging (Error, Debug and Raw Updates)
    TelegramLog::initErrorLog(__DIR__ . "/logs/error.log");
    TelegramLog::initDebugLog(__DIR__ . "/logs/debug.log");
    TelegramLog::initUpdateLog(__DIR__ . "/logs/update.log");

//    CallbackqueryCommand::addCallbackHandler(function (CallbackQuery $query) use ($telegram) {
//        $command = $query->getData();
//        $telegram->executeCommand($command);
//    });

    // Requests Limiter (tries to prevent reaching Telegram API limits)
    //    $telegram->enableLimiter();

    // Handle telegram webhook request
    $res = $telegram->handle();

} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    //echo $e;
    // Log telegram errors
    TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    // Silence is golden!
    // Uncomment this to catch log initialisation errors
    echo $e->getMessage();
}