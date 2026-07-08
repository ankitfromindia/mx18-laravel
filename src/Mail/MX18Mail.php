<?php

namespace AnkitFromIndia\MX18\Mail;

class MX18Mail
{
    private $data = [];

    /**
     * Sanitize display name for MX18 API.
     *
     * Removes control characters, angle brackets, quotes, backslashes, forward
     * slashes, semicolons, and commas — characters MX18 rejects or that would
     * corrupt email headers. Collapses whitespace and caps length at 64 chars.
     *
     * Uses `#` as the regex delimiter because the character class must
     * contain a literal `/`.
     */
    private function sanitizeDisplayName(?string $name): string
    {
        if ($name === null || trim($name) === '') {
            return '';
        }

        $sanitized = preg_replace('#[\x00-\x1F\x7F<>"\'\\\\/;,]#', '', $name);
        $sanitized = preg_replace('/\s+/', ' ', $sanitized);

        return trim(substr($sanitized, 0, 64));
    }

    public function from(string $email, string $name = null): self
    {
        $this->data['from'] = ['email' => $email];
        $sanitizedName = $this->sanitizeDisplayName($name);
        if ($sanitizedName !== '') {
            $this->data['from']['name'] = $sanitizedName;
        }
        return $this;
    }

    public function to(string $email, string $name = null, array $personalizationData = []): self
    {
        $recipient = ['email' => $email];
        $sanitizedName = $this->sanitizeDisplayName($name);
        if ($sanitizedName !== '') {
            $recipient['name'] = $sanitizedName;
        }
        if ($personalizationData) $recipient['personalizationData'] = $personalizationData;

        $this->data['to'][] = $recipient;
        return $this;
    }

    public function cc(string $email, string $name = null): self
    {
        $recipient = ['email' => $email];
        $sanitizedName = $this->sanitizeDisplayName($name);
        if ($sanitizedName !== '') {
            $recipient['name'] = $sanitizedName;
        }

        $this->data['cc'][] = $recipient;
        return $this;
    }

    public function bcc(string $email, string $name = null): self
    {
        $recipient = ['email' => $email];
        $sanitizedName = $this->sanitizeDisplayName($name);
        if ($sanitizedName !== '') {
            $recipient['name'] = $sanitizedName;
        }

        $this->data['bcc'][] = $recipient;
        return $this;
    }

    public function replyTo(string $email, string $name = null): self
    {
        $this->data['replyTo'] = ['email' => $email];
        $sanitizedName = $this->sanitizeDisplayName($name);
        if ($sanitizedName !== '') {
            $this->data['replyTo']['name'] = $sanitizedName;
        }
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

    public function unsubscribe($addUnsubscribe = false)
    {
        $this->data['unsubscribe'] = $addUnsubscribe;
        return $this;
    }

    public function campaign(int|string $campaignId): self
    {
        $this->data['campaign_id'] = $campaignId;
        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
