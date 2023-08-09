<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Good;

use VetmanagerApiGateway\ActiveRecord\GoodGroup\GoodGroup;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class GoodOnly extends AbstractGood
{
    public static function getDtoClass(): string
    {
        return GoodOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getGoodGroup(): ?GoodGroup
    {
        return $this->getGroupId() ?
            (new Facade\GoodGroup($this->activeRecordFactory))->getById($this->getGroupId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUnit(): ?Unit
    {
        return $this->getUnitId() ?
            (new Facade\Unit($this->activeRecordFactory))->getById($this->getUnitId())
            : null;
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getGoodSaleParams(): array
    {
        return (new Facade\Good($this->activeRecordFactory))->getById($this->getId())->getGoodSaleParams();
    }
}
