# MX18 Laravel API Documentation

## Installation

```bash
composer require ankitfromindia/mx18-laravel
```

## Configuration

```env
MX18_API_TOKEN=your_mx18_api_key_here
MX18_API_URL=https://api.mx18.com/api/1
MX18_WEBHOOK_SECRET=your_webhook_secret
MX18_WEBHOOK_PATH=/mx18/webhook
```

## MX18Mail Class Methods

### Basic Methods

#### `from(string $email, string $name = null): self`
Set the sender email and name.

#### `to(string $email, string $name = null, array $personalizationData = []): self`
Add a recipient with optional personalization data.

#### `cc(string $email, string $name = null): self`
Add a CC recipient.

#### `bcc(string $email, string $name = null): self`
Add a BCC recipient.

#### `replyTo(string $email, string $name = null): self`
Set reply-to address.

#### `subject(string $subject): self`
Set email subject (supports template variables).

### Content Methods

#### `html(string $content): self`
Add HTML content.

#### `text(string $content): self`
Add plain text content.

### Attachment Methods

#### `attach(string $data, string $name, string $type = 'application/octet-stream'): self`
Add file attachment (base64 encoded data).

### Advanced Methods

#### `headers(array $headers): self`
Add custom headers to the email.

#### `customArguments(array $arguments): self`
Add custom arguments for tracking/analytics.

#### `globalPersonalization(array $data): self`
Set global personalization data for all recipients.

## Complete Example

```php
use AnkitFromIndia\MX18\Http\MX18Client;
use AnkitFromIndia\MX18\Mail\MX18Mail;

$client = new MX18Client(config('mx18.api_token'));

$mail = (new MX18Mail())
    ->from('sender@domain.com', 'Sender Name')
    ->replyTo('support@domain.com', 'Support Team')
    ->to('user@example.com', 'John Doe', [
        'firstName' => 'John',
        'plan' => 'Premium',
        'expiryDate' => '2025-12-31'
    ])
    ->cc('manager@domain.com', 'Manager')
    ->subject('Welcome {{firstName}} to {{plan}} plan!')
    ->html('<h1>Hi {{firstName}}</h1><p>Your {{plan}} plan expires on {{expiryDate}}</p>')
    ->text('Hi {{firstName}}, Your {{plan}} plan expires on {{expiryDate}}')
    ->attach(base64_encode(file_get_contents('invoice.pdf')), 'invoice.pdf', 'application/pdf')
    ->headers([
        'X-Campaign-ID' => 'welcome-2025',
        'X-Mailer' => 'MX18 Laravel Package'
    ])
    ->customArguments([
        'userId' => '12345',
        'campaignType' => 'onboarding'
    ]);

$response = $client->send($mail);
```

## Response Format

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
    $response = $client->send($mail);
    echo "Success: " . $response['transactionId'];
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
```
