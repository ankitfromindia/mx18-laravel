<?php

namespace AnkitFromIndia\MX18\Tests;

use PHPUnit\Framework\TestCase;
use AnkitFromIndia\MX18\Mail\MX18Mail;

class MX18MailTest extends TestCase
{
    public function test_can_build_basic_email()
    {
        $mail = (new MX18Mail())
            ->from('sender@example.com', 'Sender')
            ->to('recipient@example.com', 'Recipient')
            ->subject('Test Subject')
            ->html('<h1>Test</h1>');

        $data = $mail->toArray();

        $this->assertEquals('sender@example.com', $data['from']['email']);
        $this->assertEquals('Sender', $data['from']['name']);
        $this->assertEquals('recipient@example.com', $data['to'][0]['email']);
        $this->assertEquals('Test Subject', $data['message']['subject']);
        $this->assertEquals('text/html', $data['message']['content'][0]['type']);
    }

    public function test_can_add_personalization()
    {
        $mail = (new MX18Mail())
            ->from('sender@example.com')
            ->to('recipient@example.com', 'John', ['name' => 'John'])
            ->globalPersonalization(['company' => 'Test Co']);

        $data = $mail->toArray();

        $this->assertEquals(['name' => 'John'], $data['to'][0]['personalizationData']);
        $this->assertEquals(['company' => 'Test Co'], $data['globalPersonalizationData']);
    }
}
