<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Service;

use DateTime;
use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class DateTimeService
{
    public function __construct(public readonly ?DateTime $dateTime)
    {
    }

    /** @param ?string $fullDateTime Example: "2020-12-14 13:51:42", "0000-00-00 00:00:00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromFullDateTimeString(?string $fullDateTime): ?self
    {
        if (!$fullDateTime || $fullDateTime = "0000-00-00 00:00:00") {
            return null;
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
        if (!$onlyDate || $onlyDate = "0000-00-00") {
            return null;
        }

        try {
            return new self(new DateTime($onlyDate));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException("Ожидали формат '0000-00-00', а получили: $onlyDate");
        }
    }

    public function isTimePresent(): bool
    {
        return ($this->dateTime && $this->dateTime->format('H:i:s') !== '01:00:00');
    }
}
