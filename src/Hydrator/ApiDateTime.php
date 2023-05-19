<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Hydrator;

use DateTime;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @property-read DateTime $dateTime Для тех случаев, когда уверены, что null и пустых значений не будет */
final class ApiDateTime
{
    public function __construct(public readonly ?DateTime $dateTimeOrNull)
    {
    }

    /**
     * @param ?string $fullDateTime Example: "2020-12-14 13:51:42", "0000-00-00 00:00:00"
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromFullDateTimeString(?string $fullDateTime): self
    {
        if (!$fullDateTime || str_starts_with($fullDateTime, "0000")) {
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

    /**
     * @param ?string $onlyDate Example: "2020-12-14", "0000-00-00"
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromOnlyDateString(?string $onlyDate): self
    {
        if (!$onlyDate || str_starts_with($onlyDate, "0000")) {
            return new self(null);
        }

        try {
            return new self(new DateTime($onlyDate));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException("Ожидали формат '0000-00-00', а получили: $onlyDate");
        }
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'dateTime' => $this->getDateTime(),
            default => $this->$name,
        };
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getDateTime(): DateTime
    {
        if (is_null($this->dateTimeOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->dateTimeOrNull;
    }

    public function isTimePresent(): bool
    {
        return ($this->dateTimeOrNull && $this->dateTimeOrNull->format('H:i:s') !== '01:00:00');
    }
}
