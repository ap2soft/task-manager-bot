<?php

namespace App\Http\Requests\TelegramWebApp;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
        ];
    }
}
