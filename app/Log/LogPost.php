<?php


namespace App\Log;

use App\Enums\LogChannelEnum;

class LogPost extends BaseLog
{
    protected static string $channel = LogChannelEnum::POST->value;
}
