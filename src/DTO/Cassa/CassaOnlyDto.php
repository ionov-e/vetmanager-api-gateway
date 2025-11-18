<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Cassa;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;

class CassaOnlyDto extends AbstractDTO implements CassaOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param int|string|null $assigned_user_id
     * @param string|null $inventarization_date
     * @param int|string|null $client_cass
     * @param int|string|null $main_cassa
     * @param int|string|null $is_blocked
     * @param int|string|null $has_unfinished_docs
     * @param string|null $status
     * @param int|string|null $clinic_id
     * @param string|null $summa_cash
     * @param string|null $summa_cashless
     * @param int|string|null $is_system
     * @param int|string|null $show_in_cashflow
     * @param string|null $type
     * @param int|string|null $cashless_to_cassa_id
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $title,
        public int|string|null $assigned_user_id,
        public ?string         $inventarization_date,
        public int|string|null $client_cass,
        public int|string|null $main_cassa,
        public int|string|null $is_blocked,
        public int|string|null $has_unfinished_docs,
        public ?string         $status,
        public int|string|null $clinic_id,
        public ?string         $summa_cash,
        public ?string         $summa_cashless,
        public int|string|null $is_system,
        public int|string|null $show_in_cashflow,
        public ?string         $type,
        public int|string|null $cashless_to_cassa_id
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return (ToString::fromStringOrNull($this->title))->getStringEvenIfNullGiven();
    }

    public function getAssignedUserId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->assigned_user_id))->getPositiveIntOrThrow();
    }

    public function getInventarizationDateAsString(): string
    {
        return (ToString::fromStringOrNull($this->inventarization_date))->getStringOrThrowIfNull();
    }

    public function getInventarizationDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->inventarization_date)->getDateTimeOrThrow();
    }

    public function getIsClientCassa(): ?bool
    {
        return ToBool::fromIntOrNull($this->client_cass)->getBoolOrNull();
    }

    public function getIsMainCassa(): bool
    {
        return ToBool::fromIntOrNull($this->main_cassa)->getBoolOrThrowIfNull();
    }

    public function getIsBlocked(): bool
    {
        return ToBool::fromIntOrNull($this->is_blocked)->getBoolOrThrowIfNull();
    }

    public function getHasUnfinishedDocs(): bool
    {
        return ToBool::fromIntOrNull($this->has_unfinished_docs)->getBoolOrThrowIfNull();
    }

    public function getStatusAsString(): string
    {
        return (ToString::fromStringOrNull($this->status))->getStringOrThrowIfNull();
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function getClinicId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->clinic_id))->getPositiveIntOrThrow();
    }

    public function getSummaCash(): float
    {
        return (float)$this->summa_cash;
    }

    public function getSummaCashless(): float
    {
        return (float)$this->summa_cashless;
    }

    public function getIsSystem(): bool
    {
        return ToBool::fromIntOrNull($this->is_system)->getBoolOrThrowIfNull();
    }

    public function getShowInCashFlow(): bool
    {
        return ToBool::fromIntOrNull($this->show_in_cashflow)->getBoolOrThrowIfNull();
    }

    public function getTypeAsString(): string
    {
        return (ToString::fromStringOrNull($this->type))->getStringOrThrowIfNull();
    }

    public function getTypeAsEnum(): TypeEnum
    {
        return TypeEnum::from($this->type);
    }

    public function getCashlessToCassaId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->cashless_to_cassa_id))->getPositiveIntOrThrow();
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setAssignedUserId(int $value): static
    {
        return self::setPropertyFluently($this, 'assigned_user_id', $value);
    }

    public function setInventarizationDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'inventarization_date', $value);
    }

    public function setInventarizationDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'inventarization_date', $value->format('Y-m-d H:i:s'));
    }

    public function setIsClientCassa(?bool $value): static
    {
        if (is_null($value)) {
            $valueToWrite = null;
        } else {
            $valueToWrite = $value ? 1 : 0;
        }

        return self::setPropertyFluently($this, 'client_cass', $valueToWrite);
    }

    public function setMainCassa(bool $value): static
    {
        return self::setPropertyFluently($this, 'main_cassa', $value ? 1 : 0);
    }

    public function setIsBlocked(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_blocked', $value ? 1 : 0);
    }

    public function setHasUnfinishedDocs(bool $value): static
    {
        return self::setPropertyFluently($this, 'has_unfinished_docs', $value ? 1 : 0);
    }

    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setStatusFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setClinicId(int $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', $value);
    }

    public function setSummaCash(float $value): static
    {
        return self::setPropertyFluently($this, 'summa_cash', (string)$value);
    }

    public function setSummaCashless(float $value): static
    {
        return self::setPropertyFluently($this, 'summa_cashless', (string)$value);
    }

    public function setIsSystem(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_system', $value ? 1 : 0);
    }

    public function setShowInCashFlow(bool $value): static
    {
        return self::setPropertyFluently($this, 'show_in_cashflow', $value ? 1 : 0);
    }

    public function setTypeFromEnum(TypeEnum $value): static
    {
        return self::setPropertyFluently($this, 'type', $value->value);
    }

    public function setTypeFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'type', $value);
    }

    public function setCashlessToCassaId(int $value): static
    {
        return self::setPropertyFluently($this, 'cashless_to_cassa_id', $value);
    }
}
