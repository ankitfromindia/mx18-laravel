<?php

namespace AnkitFromIndia\MX18\Mail;

class MX18Mail
{
    private $data = [];

    public function from(string $email, string $name = null): self
    {
        $this->data['from'] = ['email' => $email];
        if ($name) $this->data['from']['name'] = $name;
        return $this;
    }

    public function to(string $email, string $name = null, array $personalizationData = []): self
    {
        $recipient = ['email' => $email];
        if ($name) $recipient['name'] = $name;
        if ($personalizationData) $recipient['personalizationData'] = $personalizationData;
        
        $this->data['to'][] = $recipient;
        return $this;
    }

    public function cc(string $email, string $name = null): self
    {
        $recipient = ['email' => $email];
        if ($name) $recipient['name'] = $name;
        
        $this->data['cc'][] = $recipient;
        return $this;
    }

    public function bcc(string $email, string $name = null): self
    {
        $recipient = ['email' => $email];
        if ($name) $recipient['name'] = $name;
        
        $this->data['bcc'][] = $recipient;
        return $this;
    }

    public function replyTo(string $email, string $name = null): self
    {
        $this->data['replyTo'] = ['email' => $email];
        if ($name) $this->data['replyTo']['name'] = $name;
        return $this;
    }

    public function subject(string $subject): self
    {
        $this->data['message']['subject'] = $subject;
        return $this;
    }

    public function html(string $content): self
    {
        $this->data['message']['content'][] = [
            'type' => 'text/html',
            'value' => $content
        ];
        return $this;
    }

    public function text(string $content): self
    {
        $this->data['message']['content'][] = [
            'type' => 'text/plain',
            'value' => $content
        ];
        return $this;
    }

    public function attach(string $data, string $name, string $type = 'application/octet-stream'): self
    {
        $this->data['message']['attachments'][] = [
            'type' => $type,
            'name' => $name,
            'data' => $data
        ];
        return $this;
    }

    public function headers(array $headers): self
    {
        $this->data['message']['headers'] = $headers;
        return $this;
    }

    public function customArguments(array $arguments): self
    {
        $this->data['customArguments'] = $arguments;
        return $this;
    }

    public function addRecipient(string $email, string $name = null, array $personalizationData = []): self
    {
        return $this->to($email, $name, $personalizationData);
    }

    public function globalPersonalization(array $data): self
    {
        $this->data['globalPersonalizationData'] = $data;
        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
