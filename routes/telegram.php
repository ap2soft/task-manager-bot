<?php

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

Telegram::onCommand('start', function (Nutgram $bot) {
    logger('command "start"');

    $bot->sendMessage('Hi 👋🏻');
})->description('The start command!');

Telegram::onMessage(function (Nutgram $bot) {
    logger('onMessage', [$bot->message()->toArray()]);
    $bot->sendMessage(
        <<<MARKDOWN
        You said:
        > {$bot->message()->getText()}
        MARKDOWN
        ,
    );
});
