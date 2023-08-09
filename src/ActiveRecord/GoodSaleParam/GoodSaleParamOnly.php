<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodSaleParam;

use VetmanagerApiGateway\ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Good;

final class GoodSaleParamOnly extends AbstractGoodSaleParam
{
    public static function getDtoClass(): string
    {
        return GoodSaleParamOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getGood(): GoodPlusGroupAndUnitAndSaleParams
    {
        return (new Good($this->activeRecordFactory))->getById($this->getGoodId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUnit(): ?Unit
    {
        return $this->getUnitSaleId()
            ? (new \VetmanagerApiGateway\Facade\Unit($this->activeRecordFactory))->getById($this->getGoodId())
            : null;
    }
}
