<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CassaClose;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;

class CassaCloseOnlyDto extends AbstractDTO implements CassaCloseOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $date
     * @param int|string|null $id_cassa
     * @param string|null $status
     * @param int|string|null $closed_user_id
     * @param string|null $amount
     * @param string|null $amount_cashless
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $date,
        public int|string|null $id_cassa,
        public ?string         $status,
        public int|string|null $closed_user_id,
        public ?string         $amount,
        public ?string         $amount_cashless
    )
    {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getDateAsString(): string
    {
        return (ToString::fromStringOrNull($this->date))->getStringOrThrowIfNull();
    }

    public function getDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date)->getDateTimeOrThrow();
    }

    public function getCassaId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id_cassa))->getPositiveIntOrThrow();
    }

    public function getStatusAsString(): string
    {
        return (ToString::fromStringOrNull($this->status))->getStringOrThrowIfNull();
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function getClosedUserId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->closed_user_id))->getPositiveIntOrThrow();
    }

    public function getAmount(): float
    {
        return (float)$this->amount;
    }

    public function getAmountCashless(): float
    {
        return ToFloat::fromStringOrNull($this->amount_cashless)->getFloatOrThrowIfNull();
    }

    public function setDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'date', $value);
    }

    public function setDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date', $value->format('Y-m-d H:i:s'));
    }

    public function setCassaId(int $value): static
    {
        return self::setPropertyFluently($this, 'id_cassa', $value);
    }

    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setStatusFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setClosedUserId(int $value): static
    {
        return self::setPropertyFluently($this, 'closed_user_id', $value);
    }

    public function setAmount(?float $value): static
    {
        return self::setPropertyFluently($this, 'amount', is_null($value) ? null : (string)$value);
    }

    public function setAmountCashless(float $value): static
    {
        return self::setPropertyFluently($this, 'amount_cashless', (string)$value);
    }
}