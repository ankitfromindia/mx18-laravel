<?php

namespace AnkitFromIndia\MX18\Webhooks;

use Illuminate\Foundation\Events\Dispatchable;

class WebhookReceived
{
    use Dispatchable;

    public $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
