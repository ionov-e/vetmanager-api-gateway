<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Service;

use DateInterval;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class DateIntervalService
{
    public function __construct(public readonly ?DateInterval $dateInterval)
    {
    }

    /** @param ?string $hms Example: "14:45:00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringHMS(?string $hms): ?self
    {
        if (!$hms || $hms = "00:00:00") {
            return null;
        }

        try {
            list($hours, $minutes, $seconds) = sscanf($hms, '%d:%d:%d');
            return new self(new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds)));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException("Ожидаемый формат: '14:45:00'. А получили: '$hms'");
        }
    }
}
