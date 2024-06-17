<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hello, world!');
})->description('The start command!');

Telegram::onCallbackQuery(function ($data) {
    logger('callback-query', $data);
});

Telegram::onWebAppData(function ($data) {
    logger('web-app', $data);
});

