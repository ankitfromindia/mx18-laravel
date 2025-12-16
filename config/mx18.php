<?php

return [
    'api_token' => env('MX18_API_TOKEN'),
    'api_url' => env('MX18_API_URL', 'https://api.mx18.com/api/1'),
    'webhook_secret' => env('MX18_WEBHOOK_SECRET'),
    'webhook_path' => env('MX18_WEBHOOK_PATH', '/mx18/webhook'),
];
