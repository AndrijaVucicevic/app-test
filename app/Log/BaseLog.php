<?php

namespace App\Log;

use App\Enums\LogChannelEnum;
use Illuminate\Support\Facades\Log;

class BaseLog
{
    protected static string $channel = LogChannelEnum::SINGLE->value;

    public static function info(string $message, array $data = []): void
    {
        Log::channel(static::$channel)->info($message . (!empty($data) ? PHP_EOL : ''), $data);
    }

    public static function error(string $message, array $data = []): void
    {
        Log::channel(static::$channel)->error($message . (!empty($data) ? PHP_EOL : ''), $data);
    }
}
