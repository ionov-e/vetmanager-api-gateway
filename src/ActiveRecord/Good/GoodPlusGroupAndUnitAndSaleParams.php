<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Good;

use VetmanagerApiGateway\ActiveRecord\GoodGroup\GoodGroup;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\GoodSaleParamOnly;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Good\GoodPlusGroupAndUnitAndSaleParamsDto;

final class GoodPlusGroupAndUnitAndSaleParams extends AbstractGood
{
    public static function getDtoClass(): string
    {
        return GoodPlusGroupAndUnitAndSaleParamsDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, GoodPlusGroupAndUnitAndSaleParamsDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getGoodGroup(): ?GoodGroup
    {
        return $this->modelDTO->getGoodGroupOnlyDto() ?
            $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getGoodGroupOnlyDto(), GoodGroup::class)
            : null;
    }

    public function getUnit(): ?Unit
    {
        return $this->modelDTO->getUnitOnlyDto() ?
            $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUnitOnlyDto(), Unit::class)
            : null;
    }

    /** @inheritDoc */
    public function getGoodSaleParams(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getGoodSaleParamsOnlyDtos(), GoodSaleParamOnly::class);
    }
}
