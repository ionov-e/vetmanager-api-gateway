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

    /** @param ?string $fullDateTimeString Example: "2020-12-14 13:51:42", "0000-00-00 00:00:00"
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromFullDateTimeString(?string $fullDateTimeString): ?self
    {
        if (!$fullDateTimeString || $fullDateTimeString = "0000-00-00 00:00:00") {
            return null;
        }

        try {
            return new self(new DateTime($fullDateTimeString));
        } catch (Exception) {
            throw new VetmanagerApiGatewayResponseException(
                "Ожидали формат '2020-12-14 13:51:42', а получили: $fullDateTimeString"
            );
        }
    }
}
