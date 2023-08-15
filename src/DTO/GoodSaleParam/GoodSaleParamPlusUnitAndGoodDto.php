<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodSaleParam;

use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\Unit\UnitOnlyDto;

class GoodSaleParamPlusUnitAndGoodDto extends GoodSaleParamOnlyDto
{
    /**
     * @param string|null $id
     * @param string|null $good_id
     * @param string|null $price
     * @param string|null $coefficient
     * @param string|null $unit_sale_id
     * @param string|null $min_price
     * @param string|null $max_price
     * @param string|null $barcode
     * @param string|null $status
     * @param string|null $clinic_id
     * @param string|null $markup
     * @param string|null $price_formation
     * @param UnitOnlyDto|null $unitSale
     * @param GoodOnlyDto $good
     */
    public function __construct(
        protected ?string      $id,
        protected ?string      $good_id,
        protected ?string      $price,
        protected ?string      $coefficient,
        protected ?string      $unit_sale_id,
        protected ?string      $min_price,
        protected ?string      $max_price,
        protected ?string      $barcode,
        protected ?string      $status,
        protected ?string      $clinic_id,
        protected ?string      $markup,
        protected ?string      $price_formation,
        protected ?UnitOnlyDto $unitSale,
        protected GoodOnlyDto  $good
    )
    {
        parent::__construct(
            $id,
            $good_id,
            $price,
            $coefficient,
            $unit_sale_id,
            $min_price,
            $max_price,
            $barcode,
            $status,
            $clinic_id,
            $markup,
            $price_formation
        );
    }

    public function getUnitOnlyDto(): ?UnitOnlyDto
    {
        return $this->unitSale;
    }

    public function getGoodOnlyDto(): GoodOnlyDto
    {
        return $this->good;
    }
}
