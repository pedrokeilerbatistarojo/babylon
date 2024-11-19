<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Contracts\NotificationInterface;
use App\Shared\Infrastructure\Logs\Listeners\TraitLogger;
use Cache;
use Illuminate\Support\Carbon;
use stdClass;

class TelegramNotification implements NotificationInterface
{
    use TraitLogger;

    private string $botToken;

    private string $apiUrl;

    const MAX_MESSAGE_LENGTH = 4096;

    public function __construct(string $botToken)
    {
        $this->botToken = $botToken;
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
    }

    public function send(string $recipient, string $subject, string $message): bool
    {

        if (! $this->botToken) {
            return false;
        }

        //If was sent return
        $id = md5($subject);
        if (Cache::has($id)) {
            return true;
        }

        if (! str_contains($message, 'Exception')) {
            $message = "$subject:\n".$message;
        }

        // Split message
        $messages = $this->splitMessage($message);
        foreach ($messages as $msg) {
            if (! $this->sendMessage($recipient, $msg)) {
                return false;
            }
        }

        Cache::set($id, 1, now()->addHour(1));

        return true;
    }

    private function splitMessage(string $message): array
    {
        // Split the message into parts of up to 4096 characters
        return str_split($message, self::MAX_MESSAGE_LENGTH);
    }

    private function sendMessage(string $recipient, string $message): bool
    {
        $data = [
            'chat_id' => $recipient,
            'text' => $message,
            'parse_mode' => 'HTML', //HTML, MarkdownV2, Markdown
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);

        if ($httpCode !== 200) {

            $obj = new stdClass;
            $obj->timestamp = Carbon::now();
            $obj->request = $data;
            $obj->response = $response;
            $body = json_encode($obj, JSON_PRETTY_PRINT);

            $this->storeLogByDate('telegram', $body);
        }

        return $httpCode === 200 && $response !== false;
    }
}
