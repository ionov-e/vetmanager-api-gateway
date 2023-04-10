<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use DateInterval;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @property-read DateInterval $dateInterval Для тех случаев, когда уверены, что null и пустых значений не будет */
final class DateIntervalContainer
{
    public function __construct(public readonly ?DateInterval $dateIntervalNullable)
    {
    }

    /** @param ?string $hms Example: "14:45:00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringHMS(?string $hms): ?self
    {
        if (!$hms || "00:00:00" == $hms) {
            return new self(null);
        }

        try {
            list($hours, $minutes, $seconds) = sscanf($hms, '%d:%d:%d');
            return new self(new DateInterval(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds)));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException("Ожидаемый формат: '14:45:00'. А получили: '$hms'");
        }
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            'dateInterval' => $this->dateIntervalNullable,
            default => $this->$name,
        };
    }
}
