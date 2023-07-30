<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\AbstractComboManualName;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\ComboManualNameOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read ComboManualItemOnlyDto $originalDto
 * @property positive-int $id
 * @property positive-int $comboManualId
 * @property string $title Default: ''
 * @property string $value Default: ''
 * @property string $dopParam1 Default: ''
 * @property string $dopParam2 Default: ''
 * @property string $dopParam3 Default: ''
 * @property bool $isActive Default: true
 * @property-read array{
 *       id: string,
 *       combo_manual_id: string,
 *       title: string,
 *       value: string,
 *       dop_param1: string,
 *       dop_param2: string,
 *       dop_param3: string,
 *       is_active: string,
 *       comboManualName: array{
 *               id: string,
 *               title: string,
 *               is_readonly: string,
 *               name: string
 *       }
 *  } $originalDataArray comboManualName при GetAll тоже
 * @property-read ComboManualNameOnly $comboManualName
 */
abstract class AbstractComboManualItem extends AbstractActiveRecord implements ComboManualItemOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'comboManualItem';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, ComboManualItemOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getComboManualId(): int
    {
        return $this->modelDTO->getComboManualId();
    }

    /** @inheritDoc */
    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getValue(): string
    {
        return $this->modelDTO->getValue();
    }

    /** @inheritDoc */
    public function getDopParam1(): string
    {
        return $this->modelDTO->getDopParam1();
    }

    /** @inheritDoc */
    public function getDopParam2(): string
    {
        return $this->modelDTO->getDopParam2();
    }

    /** @inheritDoc */
    public function getDopParam3(): string
    {
        return $this->modelDTO->getDopParam3();
    }

    /** @inheritDoc */
    public function getIsActive(): bool
    {
        return $this->modelDTO->getIsActive();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setComboManualId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setComboManualId($value));
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setValue(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setValue($value));
    }

    /** @inheritDoc */
    public function setDopParam1(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDopParam1($value));
    }

    /** @inheritDoc */
    public function setDopParam2(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDopParam2($value));
    }

    /** @inheritDoc */
    public function setDopParam3(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDopParam3($value));
    }

    /** @inheritDoc */
    public function setIsActive(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsActive($value));
    }

    abstract public function getComboManualName(): AbstractComboManualName;
}
