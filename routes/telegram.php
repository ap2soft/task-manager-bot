<?php

use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

Telegram::onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hi 👋🏻');
})->description('The start command');

Telegram::onCommand('help', function (Nutgram $bot) {
    $bot->sendMessage('How can I assist you today?');
})->description('The help command');

Telegram::onMessage(function (Nutgram $bot) {
    logger('onMessage', [$bot->message()->toArray()]);
    $bot->sendMessage(
        <<<MARKDOWN
        You said:
        > {$bot->message()->getText()}
        MARKDOWN
        ,
        parse_mode: ParseMode::MARKDOWN,
    );
});
