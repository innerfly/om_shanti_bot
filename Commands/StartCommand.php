<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Commands\UserCommands\WeatherCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Request;

/**
 * Start command
 *
 * Gets executed when a user first starts using the bot.
 */
class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.1.0';

    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $text = '🕉 Namaste! 🕉' . PHP_EOL . '/weather or /help to see all commands!';

        $inline_keyboard = new InlineKeyboard(
            [
                ['text' => 'open url', 'url' => 'https://github.com/php-telegram-bot/core'],
            ]
        );

        $inline_keyboard = new InlineKeyboard([
            ['text' => 'Weather', 'callback_data' => 'weather'],
            ['text' => 'Start', 'callback_data' => 'start'],
            ['text' => 'Help', 'callback_data' => 'help'],
        ]);


        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $inline_keyboard,
        ];

        return Request::sendMessage($data);
    }
}
