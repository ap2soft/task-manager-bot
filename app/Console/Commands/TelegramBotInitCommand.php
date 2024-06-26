<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeDefault;

use function Laravel\Prompts\{error, info, note, spin, warning};

class TelegramBotInitCommand extends Command
{
    protected $signature = 'bot:init';

    protected $description = "Set the bot's description, image, commands, etc.";

    public function __construct(private Nutgram $bot)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->testBotToken();
        $this->registerBotCommands();
        $this->setBotDescription();
        $this->setWebhook();

        info('✅ Bot installed successfully');

        return self::SUCCESS;
    }

    private function testBotToken(): void
    {
        spin(fn() => $this->bot->getMe(), 'Checking bot token validity...');

        note('✅ Token is valid');
    }

    private function registerBotCommands(): void
    {
        spin(
            fn() => $this->bot->setMyCommands(
                // prettier-ignore
                [
                    BotCommand::make('start', 'Show working'),
                    BotCommand::make('help', 'Show information'),
                ],
                new BotCommandScopeDefault(),
            ),
            'Registering bot commands...',
        );

        note('✅ Bot commands registered');
    }

    private function setBotDescription(): void
    {
        spin(function () {
            $this->bot->setMyDescription(
                <<<TEXT
                📋 Easily add, organize, and manage your tasks on Telegram. Create tasks, set deadlines, prioritize, and get reminders to boost your productivity! 🚀
                TEXT
                ,
            );
            $this->bot->setMyShortDescription(
                <<<TEXT
                📋 Add, organize, and manage tasks on Telegram. Boost your productivity! 🚀
                TEXT
                ,
            );
        }, 'Setting bot description...');

        note('✅ Bot description set');
    }

    private function setWebhook(): void
    {
        if (app()->isLocal()) {
            warning('🚫 Webhook registration skipped for local environment');

            return;
        }

        $url = route('telegram-webhook');

        try {
            spin(fn() => $this->call('nutgram:hook:set', ['url' => $url]), 'Checking bot token validity...');
            note('✅ Webhook is registered');
        } catch (Exception $e) {
            error("❌ Error registering webhook [$url]" . PHP_EOL . $e->getMessage());
        }
    }
}
