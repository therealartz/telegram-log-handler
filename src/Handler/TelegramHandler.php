<?php declare(strict_types=1);

namespace TelegramLog\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramHandler extends AbstractProcessingHandler
{
    /**
     * Telegram Bot API token.
     *
     * @var string
     */
    protected $botToken;

    /**
     * Name of recipient or chat id.
     *
     * @var string|int
     */
    protected $chatId;

    /**
     * HTTP Client for communicating with Telegram API.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    public function __construct(string $botToken, $chatId, int $level = Logger::DEBUG, $bubble = true)
    {
        $this->botToken = $botToken;

        $this->chatId = $chatId;

        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => "https://api.telegram.org/bot{$this->botToken}/",
            'timeout' => 2,
        ]);

        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $message = $record['formatted'];

        // Telegram has a maximum message length of 4096 characters.
        if (mb_strlen($message) < 4096) {
            $this->sendText($message);
        } else {
            $this->sendTextAsFile($record);
        }
    }

    protected function sendText($message): void
    {
        $this->httpClient->post('sendMessage', [
            'query' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ],
        ]);
    }

    protected function sendTextAsFile(array $record): void
    {
        $fileName = $record['channel'] . '_' . $record['datetime']->format('mdY-His');

        $this->httpClient->post('sendDocument', [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $this->chatId,
                ],
                [
                    'name' => 'document',
                    'contents' => $record['formatted'],
                    'filename' => "{$fileName}.log",
                    'headers' => [
                        'Content-Type' => 'text/plain; charset=UTF8',
                    ],
                ],
            ],
        ]);
    }
}
