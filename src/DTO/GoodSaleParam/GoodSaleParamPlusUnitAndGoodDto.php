<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodSaleParam;

use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\Unit\UnitOnlyDto;

class GoodSaleParamPlusUnitAndGoodDto extends GoodSaleParamOnlyDto
{
    /**
     * @param int|string|null $id
     * @param int|string|null $good_id
     * @param string|null $price
     * @param int|string|null $coefficient
     * @param int|string|null $unit_sale_id
     * @param string|null $min_price
     * @param string|null $max_price
     * @param string|null $barcode
     * @param string|null $status
     * @param int|string|null $clinic_id
     * @param string|null $markup
     * @param string|null $price_formation
     * @param UnitOnlyDto|null $unitSale
     * @param GoodOnlyDto $good
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $good_id,
        protected ?string         $price,
        protected int|string|null $coefficient,
        protected int|string|null $unit_sale_id,
        protected ?string         $min_price,
        protected ?string         $max_price,
        protected ?string         $barcode,
        protected ?string         $status,
        protected int|string|null $clinic_id,
        protected ?string         $markup,
        protected ?string         $price_formation,
        protected ?UnitOnlyDto    $unitSale,
        protected GoodOnlyDto     $good
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
