<?php

use Illuminate\Support\Facades\Route;
use AnkitFromIndia\MX18\Webhooks\WebhookController;

Route::post(config('mx18.webhook_path'), [WebhookController::class, 'handle'])
    ->name('mx18.webhook');
