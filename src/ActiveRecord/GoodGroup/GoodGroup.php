<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodGroup;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\GoodGroup\GoodGroupOnlyDto;
use VetmanagerApiGateway\DTO\GoodGroup\GoodGroupOnlyDtoInterface;

/**
 * @property-read GoodGroupOnlyDto $originalDto
 * @property string $title
 * @property ?int $priceId
 * @property bool $isService Default: false
 * @property ?float $markup
 * @property bool $isShowInVaccines Default: false
 * @property-read array{
 *     id: string,
 *     title: string,
 *     is_service: string,
 *     markup: ?string,
 *     is_show_in_vaccines: string,
 *     price_id: ?string
 * } $originalDataArray
 */
class GoodGroup extends AbstractActiveRecord implements GoodGroupOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'goodGroup';
    }

    public static function getDtoClass(): string
    {
        return GoodGroupOnlyDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, GoodGroupOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getIsService(): bool
    {
        return $this->modelDTO->getIsService();
    }

    /** @inheritDoc */
    public function getMarkup(): ?float
    {
        return $this->modelDTO->getMarkup();
    }

    /** @inheritDoc */
    public function getIsShowInVaccines(): bool
    {
        return $this->modelDTO->getIsShowInVaccines();
    }

    /** @inheritDoc */
    public function getPriceId(): ?int
    {
        return $this->modelDTO->getPriceId();
    }

    /** @inheritDoc */
    public function setId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setIsService(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsService($value));
    }

    /** @inheritDoc */
    public function setMarkup(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMarkup($value));
    }

    /** @inheritDoc */
    public function setIsShowInVaccines(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsShowInVaccines($value));
    }

    /** @inheritDoc */
    public function setPriceId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPriceId($value));
    }
}
