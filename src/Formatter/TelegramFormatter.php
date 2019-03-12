<?php declare(strict_types=1);

namespace TelegramLog\Formatter;

use Monolog\Formatter\LineFormatter;

class TelegramFormatter extends LineFormatter
{
    /**
     * {@inheritdoc}
     */
    public function format(array $record): string
    {
        $record['message'] = "```{$record['message']}```";

        $format = parent::format($record);

        // Workaround when using markdown parse mode
        return str_replace('_', '\_', $format);
    }
}
