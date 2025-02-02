<?php
namespace App\Service;

use GuzzleHttp\Client;

class ChatGptService
{
    private Client $client;
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->client = new Client(['base_uri' => 'https://api.openai.com/v1/']);
        $this->apiKey = $apiKey;
    }

    public function getChatResponse(string $message): string
    {
        $response = $this->client->post('chat/completions', [
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model'    => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $message]],
                'temperature' => 0.7,
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        return $body['choices'][0]['message']['content'] ?? 'Ошибка';
    }
}
