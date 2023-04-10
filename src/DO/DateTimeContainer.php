<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use DateTime;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @property-read DateTime $dateTime Для тех случаев, когда уверены, что null и пустых значений не будет */
final class DateTimeContainer
{
    public function __construct(public readonly ?DateTime $dateTimeNullable)
    {
    }

    /** @param ?string $fullDateTime Example: "2020-12-14 13:51:42", "0000-00-00 00:00:00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromFullDateTimeString(?string $fullDateTime): ?self
    {
        if (!$fullDateTime || "0000-00-00 00:00:00" == $fullDateTime) {
            return new self(null);
        }

        try {
            return new self(new DateTime($fullDateTime));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException(
                "Ожидали формат '2020-12-14 13:51:42', а получили: $fullDateTime"
            );
        }
    }

    /** @param ?string $onlyDate Example: "2020-12-14", "0000-00-00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromOnlyDateString(?string $onlyDate): ?self
    {
        if (!$onlyDate || "0000-00-00" == $onlyDate) {
            return new self(null);
        }

        try {
            return new self(new DateTime($onlyDate));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException("Ожидали формат '0000-00-00', а получили: $onlyDate");
        }
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            'dateTime' => $this->dateTimeNullable,
            default => $this->$name,
        };
    }

    public function isTimePresent(): bool
    {
        return ($this->dateTimeNullable && $this->dateTimeNullable->format('H:i:s') !== '01:00:00');
    }
}
