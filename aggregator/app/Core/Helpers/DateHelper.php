<?php

namespace App\Core\Helpers;

class DateHelper
{
    /**
     * @throws \Exception
     */
    public static function formatDateToUtc(?string $date = null, ?string $timezone = null): ?\DateTime
    {
        if (!is_null($date)) {
            $result = new \DateTime($date, new \DateTimeZone($timezone ?? 'Europe/Moscow'));
            $result->setTimezone(new \DateTimeZone('UTC'));
        }
        return $result ?? null;
    }
}
