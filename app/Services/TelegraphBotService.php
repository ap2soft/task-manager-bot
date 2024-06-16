<?php

namespace App\Services;

use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class TelegraphBotService
{
    public function getApiUrlForBot(TelegraphBot $bot): Stringable
    {
        return Str::of(config('telegraph.telegram_api_url'))
            ->finish('/')
            ->append('bot', $bot->token);
    }

    /**
     * @throws RequestException
     */
    public function sendApiRequest(TelegraphBot $bot, string $action, array $data = [])
    {
        $url = $this->getApiUrlForBot($bot)->finish('/');

        return Http::post($url->append($action), $data)->throw()->json();
    }
}
