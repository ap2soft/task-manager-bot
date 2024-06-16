<?php

namespace App\Actions;

use DefStudio\Telegraph\DTO\TelegramUpdate;
use Exception;
use RuntimeException;

class ProcessUserMessage
{
    /**
     * @throws Exception
     */
    public function __invoke(TelegramUpdate $update): void
    {
        dump($update);

        $message = $update->message();

        if ($message) {
            $chat = $message->chat();
        } else {
            throw new RuntimeException('Unexpected update type: $update->message() is empty');
        }
    }
}
