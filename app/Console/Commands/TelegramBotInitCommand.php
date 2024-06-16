<?php

namespace App\Console\Commands;

use App\Services\TelegraphBotService;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Console\Command;

use function Laravel\Prompts\{error, info, note, spin};

class TelegramBotInitCommand extends Command
{
    protected $signature = 'bot:init';

    protected $description = "Set the bot's description, image, commands, etc.";

    private TelegraphBotService $botService;

    private ?TelegraphBot $bot;

    public function handle(TelegraphBotService $botService): int
    {
        $this->botService = $botService;

        $this->bot = TelegraphBot::first();

        if (!$this->bot) {
            error('❌ Bot not found.' . PHP_EOL . 'Run `php artisan telegraph:new-bot` to add one.');

            return self::FAILURE;
        }

        $this->testBotToken();
        $this->registerBotCommands();
        $this->setBotDescription();
        // TODO: Register the webhook

        info('✅ Bot installed successfully');

        return self::SUCCESS;
    }

    private function testBotToken(): void
    {
        spin(fn() => $this->botService->sendApiRequest($this->bot, 'getMe'), 'Checking bot token validity...');

        note('✅ Token is valid');
    }

    private function registerBotCommands(): void
    {
        spin(
            fn() => $this->bot
                ->registerCommands([
                    'start' => 'Show information',
                ])
                ->send(),
            'Registering bot commands...',
        );

        note('✅ Bot commands registered');
    }

    private function setBotDescription(): void
    {
        spin(function () {
            $url = $this->botService->getApiUrlForBot($this->bot);

            $this->botService->sendApiRequest($this->bot, 'setMyDescription', [
                'description' => <<<'TEXT'
                📋 Easily add, organize, and manage your tasks on Telegram. Create tasks, set deadlines, prioritize, and get reminders to boost your productivity! 🚀
                TEXT
            ,
            ]);
            $this->botService->sendApiRequest($this->bot, 'setMyShortDescription', [
                'description' => <<<'TEXT'
                📋 Add, organize, and manage tasks on Telegram. Boost your productivity! 🚀
                TEXT
            ,
            ]);
        }, 'Setting bot description...');

        note('✅ Bot description set');
    }
}
