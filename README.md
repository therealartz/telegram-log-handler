# telegram-log-handler: Monolog handler for sending logs by Telegram bot 

This package provides Handler for Monolog Logger.
For me in some cases it's very convenient to receive logs in Telegram, so I write short handler for using in any project.

# Requirements
  
* PHP 7.1+
* CURL extension activated

# Usage

## Set up handler

```php
<?php

use Monolog\Logger;
use TelegramLog\Handler\TelegramHandler;
use TelegramLog\Formatter\TelegramFormatter;

$chatId = '@yourChatId';
$botToken = 'your-bot-token';

$logger = new Logger(
    'logger_dev',
    [
        (new TelegramHandler(BOT_TOKEN, CHAT_ID))
            ->setFormatter(new TelegramFormatter()),
    ]
);

$logger->info('My logger works!');
```
