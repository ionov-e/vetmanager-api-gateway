<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodSaleParam;

use VetmanagerApiGateway\ActiveRecord\Good\AbstractGood;
use VetmanagerApiGateway\ActiveRecord\Good\GoodOnly;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamPlusUnitAndGoodDto;

final class GoodSaleParamPlusUnitAndGood extends AbstractGoodSaleParam
{
    public static function getDtoClass(): string
    {
        return GoodSaleParamPlusUnitAndGoodDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, GoodSaleParamPlusUnitAndGoodDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getGood(): AbstractGood
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getGoodOnlyDto(), GoodOnly::class);
    }

    public function getUnit(): ?Unit
    {
        return $this->modelDTO->getUnitOnlyDto()
            ? $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUnitOnlyDto(), Unit::class)
            : null;

    }
}
