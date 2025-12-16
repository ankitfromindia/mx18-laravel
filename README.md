# MX18 Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ankitfromindia/mx18-laravel.svg?style=flat-square)](https://packagist.org/packages/ankitfromindia/mx18-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/ankitfromindia/mx18-laravel.svg?style=flat-square)](https://packagist.org/packages/ankitfromindia/mx18-laravel)

Laravel package for [MX18](https://mx18.com) Email API integration. Send single/bulk emails and handle webhooks with ease.

## Features

- ✅ Send single emails
- ✅ Send bulk emails  
- ✅ Handle webhooks with signature verification
- ✅ Support for HTML/text content
- ✅ File attachments
- ✅ Email personalization
- ✅ CC/BCC recipients
- ✅ Laravel auto-discovery

## Requirements

- PHP 8.3+
- Laravel 10.0+, 11.0+, or 12.0+
- MX18 account with API token

## Installation

```bash
composer require ankitfromindia/mx18-laravel
```

## Configuration

### 1. Publish Config

```bash
php artisan vendor:publish --tag=mx18-config
```

### 2. Environment Variables

Add to your `.env`:

```env
MX18_API_TOKEN=your_api_token_here
MX18_WEBHOOK_SECRET=your_webhook_secret_optional
MX18_WEBHOOK_PATH=/mx18/webhook
```

### 3. Get API Token

1. Sign up at [MX18](https://mx18.com)
2. Get your API token from [Account Settings](https://app.mx18.com/account-settings)
3. Verify your sender domain

## Usage

### Basic Email

```php
use AnkitFromIndia\MX18\Mail\MX18Mail;
use AnkitFromIndia\MX18\Facades\MX18;

$mail = (new MX18Mail())
    ->from('sender@yourdomain.com', 'Your Name')
    ->to('recipient@example.com', 'Recipient Name')
    ->subject('Welcome to Our Service')
    ->html('<h1>Hello {{name}}!</h1><p>Welcome to our platform.</p>')
    ->text('Hello {{name}}! Welcome to our platform.');

$response = MX18::send($mail);
```

### Advanced Email with Personalization

```php
$mail = (new MX18Mail())
    ->from('noreply@yourdomain.com', 'Your Company')
    ->to('user@example.com', 'John Doe', ['name' => 'John', 'plan' => 'Premium'])
    ->cc('manager@yourdomain.com', 'Manager')
    ->replyTo('support@yourdomain.com', 'Support Team')
    ->subject('Your {{plan}} account is ready!')
    ->html('<h1>Hi {{name}}</h1><p>Your {{plan}} plan is now active.</p>')
    ->globalPersonalization(['company' => 'Your Company']);

$response = MX18::send($mail);
```

### File Attachments

```php
$pdfContent = base64_encode(file_get_contents('/path/to/file.pdf'));

$mail = (new MX18Mail())
    ->from('sender@yourdomain.com')
    ->to('recipient@example.com')
    ->subject('Invoice Attached')
    ->html('<p>Please find your invoice attached.</p>')
    ->attach($pdfContent, 'invoice.pdf', 'application/pdf');

$response = MX18::send($mail);
```

### Bulk Email

```php
$mails = [
    (new MX18Mail())
        ->from('newsletter@yourdomain.com')
        ->to('user1@example.com', 'User One')
        ->subject('Newsletter #1')
        ->html('<h1>Newsletter Content</h1>'),
    
    (new MX18Mail())
        ->from('newsletter@yourdomain.com')
        ->to('user2@example.com', 'User Two')
        ->subject('Newsletter #2')
        ->html('<h1>Different Content</h1>'),
];

$responses = MX18::sendBulk($mails);

foreach ($responses as $response) {
    echo "Transaction ID: " . $response['transactionId'] . "\n";
}
```

## Webhooks

### 1. Setup Webhook URL

Get your webhook URL:

```php
$webhookUrl = MX18::getWebhookUrl();
// Returns: https://yourdomain.com/mx18/webhook
```

Configure this URL in your [MX18 Dashboard](https://app.mx18.com) under Webhooks settings.

### 2. Handle Webhook Events

Create an event listener:

```php
// In EventServiceProvider.php
use AnkitFromIndia\MX18\Webhooks\WebhookReceived;

protected $listen = [
    WebhookReceived::class => [
        'App\Listeners\HandleMX18Webhook',
    ],
];
```

Create the listener:

```php
// app/Listeners/HandleMX18Webhook.php
<?php

namespace App\Listeners;

use AnkitFromIndia\MX18\Webhooks\WebhookReceived;

class HandleMX18Webhook
{
    public function handle(WebhookReceived $event)
    {
        $payload = $event->payload;
        
        // Handle different event types
        switch ($payload['event']) {
            case 'delivered':
                // Email was delivered
                break;
            case 'opened':
                // Email was opened
                break;
            case 'clicked':
                // Link was clicked
                break;
            case 'bounced':
                // Email bounced
                break;
        }
    }
}
```

### 3. Webhook Security

The package automatically verifies webhook signatures when `MX18_WEBHOOK_SECRET` is set. Invalid signatures return 401 Unauthorized.

## API Response

Successful API calls return:

```php
[
    'transactionId' => 'abc123xyz456',
    'status' => 'Accepted',
    'message' => 'Email request has been accepted for delivery.'
]
```

## Error Handling

```php
try {
    $response = MX18::send($mail);
    echo "Email sent! Transaction ID: " . $response['transactionId'];
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

## Configuration Options

```php
// config/mx18.php
return [
    'api_token' => env('MX18_API_TOKEN'),
    'api_url' => env('MX18_API_URL', 'https://api.mx18.com/api/1'),
    'webhook_secret' => env('MX18_WEBHOOK_SECRET'),
    'webhook_path' => env('MX18_WEBHOOK_PATH', '/mx18/webhook'),
];
```

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security vulnerabilities, please email security@ankitfromindia.com instead of using the issue tracker.

## Credits

- [Ankit Vishwakarma](https://github.com/ankitfromindia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
