<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualName;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNameOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNameOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read ComboManualNameOnlyDto $originalDto
// * @property positive-int $id
// * @property non-empty-string $title
// * @property bool $isReadonly
// * @property non-empty-string $name
// * @property-read array{
// *       id: string,
// *       title: string,
// *       is_readonly: string,
// *       name: string,
// *       comboManualItems: list<array{
// *                                    id: string,
// *                                    combo_manual_id: string,
// *                                    title: string,
// *                                    value: string,
// *                                    dop_param1: string,
// *                                    dop_param2: string,
// *                                    dop_param3: string,
// *                                    is_active: string
// *                                   }
// *                             >
// *   } $originalDataArray 'comboManualItems' массив только при GetById
// * @property-read ComboManualItemOnly[] comboManualItems
// */
abstract class AbstractComboManualName extends AbstractActiveRecord implements ComboManualNameOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'comboManualName';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, ComboManualNameOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\ComboManualName($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\ComboManualName($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\ComboManualName($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getIsReadonly(): bool
    {
        return $this->modelDTO->getIsReadonly();
    }

    /** @inheritDoc */
    public function getName(): string
    {
        return $this->modelDTO->getName();
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setIsReadonly(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsReadonly($value));
    }

    /** @inheritDoc */
    public function setName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setName($value));
    }

    /** @return AbstractComboManualItem[] */
    abstract public function getComboManualItems(): array;
}
