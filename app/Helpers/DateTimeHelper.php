<?php


namespace App\Helpers;


class DateTimeHelper
{
    public static function webDateTimeFormat(string|null $dateTime): string
    {
        return !empty($dateTime) ? date('d.m.Y. H:i:s', strtotime($dateTime)) : '';
    }

    public static function webDateFormat(string|null $dateTime): string
    {
        return !empty($dateTime) ? date('d.m.Y.', strtotime($dateTime)) : '';
    }

    public static function formatDatesForBetween(string $dateFrom, string $dateTo): array
    {
        return [
            date('Y-m-d 00:00:00', strtotime($dateFrom)),
            date('Y-m-d 23:59:59', strtotime($dateTo))
        ];
    }
}
