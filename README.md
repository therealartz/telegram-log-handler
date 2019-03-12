# telegram-log-handler: Monolog handler for sending logs by Telegram bot 

This package provides Handler for Monolog Logger.

For me in some cases it's very convenient to receive logs in Telegram, so I wrote a short handler for using in any project.

# Requirements
  
* PHP 7.1+
* cURL and mbstring extensions activated

# Usage

## Set up handler

```php
<?php

use Monolog\Logger;
use TelegramLog\Handler\TelegramHandler;

$botToken = 'your-bot-token';
$chatId = '@yourChatId';

$logger = new Logger(
    'logger_dev',
    [
        new TelegramHandler($botToken, $chatId)
    ]
);

$logger->info('My logger works!');
```

## Set up handler in Laravel

According to Laravel [docs](https://laravel.com/docs/5.8/logging#advanced-monolog-channel-customization) in `config/logging.php` add channel:

```php
return [

    // ...
    
    'channels' => [
    
        // ...
        
        'telegram' => [
            'driver' => 'monolog',
            'handler' => \TelegramLog\Handler\TelegramHandler::class,
            'with' => [
                'botToken' => 'your-bot-token',
                'chatId' => '@yourChatId',
            ],
        ],
    ]б
];
```

And use by set in .env `LOG_CHANNEL=telegram`
