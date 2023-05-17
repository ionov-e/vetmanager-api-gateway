<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\GoodGroupDto;

/**
 * @property-read GoodGroupDto $originalDto
 * @property string $title
 * @property ?int $priceId
 * @property bool $isService Default: false
 * @property ?float $markup
 * @property bool $isShowInVaccines Default: false
 * @property array{
 *     "id": string,
 *     "title": string,
 *     "is_service": string,
 *     "markup": ?string,
 *     "is_show_in_vaccines": string,
 *     "price_id": ?string
 * } $originalDataArray
 */
final class GoodGroup extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use AllGetRequestsTrait;

    /** @return ApiModel::GoodGroup */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::GoodGroup;
    }

    public function __get(string $name): mixed
    {
        return $this->originalDto->$name;
    }
}
