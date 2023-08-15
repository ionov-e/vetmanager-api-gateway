<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ApiDataInterpreter;

use DateInterval;
use Throwable;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class ToDateInterval
{
    public function __construct(private readonly ?DateInterval $dateIntervalOrNull)
    {
    }

    /**
     * @param ?string $hms Example: "14:45:00"
     * @throws VetmanagerApiGatewayResponseException
     * @psalm-suppress PossiblyNullArgument, PossiblyNullArrayAccess - я все равно ловлю если DateInterval не создается
     */
    public static function fromStringHMS(?string $hms): self
    {
        if (!$hms || "00:00:00" == $hms) {
            return new self(null);
        }

        try {
            $timeAsArray = sscanf($hms, '%d:%d:%d');
            $dateTime = new DateInterval(sprintf('PT%dH%dM%dS', $timeAsArray[0], $timeAsArray[1], $timeAsArray[2]));
        } catch (Throwable) {
            throw new VetmanagerApiGatewayResponseException("Ожидаемый формат: '14:45:00'. А получили: '$hms'");
        }

        return new self($dateTime);
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет */
    public function getDateIntervalOrNull(): ?DateInterval
    {
        return $this->dateIntervalOrNull;
    }
}
