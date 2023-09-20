<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ApiDataInterpreter;

use DateTime;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class ToDateTime
{
    public function __construct(private readonly ?DateTime $dateTimeOrNull)
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

    public function getDateTimeOrNull(): ?DateTime
    {
        return $this->dateTimeOrNull;
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateTimeOrThrow(): DateTime
    {
        if (is_null($this->dateTimeOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->dateTimeOrNull;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getAsDataBaseStringOrThrowIfNull(): string
    {
        if (is_null($this->dateTimeOrNull)) {
            throw new VetmanagerApiGatewayException("Не должно было быть null");
        }

        return $this->dateTimeOrNull->format('Y-m-d H:i:s');
    }

    public static function isTimePresent(?DateTime $dateTimeNullable): bool
    {
        return ($dateTimeNullable && $dateTimeNullable->format('H:i:s') !== '00:00:00');
    }
}
