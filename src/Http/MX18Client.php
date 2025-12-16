<?php

namespace AnkitFromIndia\MX18\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use AnkitFromIndia\MX18\Mail\MX18Mail;

class MX18Client
{
    private $client;
    private $apiToken;
    private $baseUrl;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = config('mx18.api_url');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function send(MX18Mail $mail): array
    {
        try {
            $response = $this->client->post('/mail/send', [
                'json' => $mail->toArray()
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new \Exception('MX18 API Error: ' . $e->getMessage());
        }
    }

    public function sendBulk(array $mails): array
    {
        $results = [];
        foreach ($mails as $mail) {
            $results[] = $this->send($mail);
        }
        return $results;
    }

    public function getWebhookUrl(): string
    {
        return url(config('mx18.webhook_path'));
    }
}
