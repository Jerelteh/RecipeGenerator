<?php

namespace App\AI;

use App\Models\Recipe;
use Illuminate\Support\Facades\Http;

class Chat
{
    protected $messages = [];
    public function messages() // returns messages
    {
        return $this->messages;
    }
    public function systemMessage(string $message) // system message
    {
        $this->messages[] = [
            "role" => "system",
            "content" => $message
        ];
        return $this;
    }
    public function send(string $message) // sends prompt and returns response
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $response = Http::withToken(config('services.openai.apiKey')) // **KEY**
            ->post(
                'https://api.openai.com/v1/chat/completions',
                [
                    "model" => "gpt-4o-mini",
                    "messages" => $this->messages
                ]
            )->json('choices.0.message.content');

        return $response;
    }
    public function generateImage(string $prompt)
    {
        $response = Http::withToken(config('services.openai.apiKey'))
            ->post(
                'https://api.openai.com/v1/images/generations',
                [
                    "prompt" => $prompt,
                    "n" => 1,
                    "size" => "1024x1024"
                ]
            )->json('data.0.url');

        return $response;
    }
}
