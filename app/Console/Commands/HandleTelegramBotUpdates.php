<?php

namespace App\Console\Commands;

use App\Actions\ProcessUserMessage;
use DefStudio\Telegraph\DTO\TelegramUpdate;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

use function Laravel\Prompts\{error};

class HandleTelegramBotUpdates extends Command
{
    protected $signature = 'bot:poll';

    protected $description = 'Poll Telegram for updates';

    private TelegraphBot $bot;

    public function handle(ProcessUserMessage $processUserMessage): int
    {
        // TODO: Unregister webhook before start polling

        try {
            $this->bot = TelegraphBot::firstOrFail();
        } catch (ModelNotFoundException) {
            error('Bot not found');

            return self::FAILURE;
        }

        $offset = 0;

        while (true) {
            /** @var Collection<TelegramUpdate> $updates */
            $updates = $this->bot->updates(timeout: 5, offset: $offset);

            foreach ($updates as $update) {
                $processUserMessage($update);

                if ($update->id() >= $offset) {
                    $offset = $update->id() + 1;
                }
            }

            sleep(1);
        }

        return self::SUCCESS;
    }
}
