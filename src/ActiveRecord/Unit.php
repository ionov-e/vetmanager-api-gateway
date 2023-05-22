<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\Enum\Unit\Status;
use VetmanagerApiGateway\DTO\UnitDto;

/**
 * @property-read UnitDto $originalDto
 * @property int $id
 * @property string $title
 * @property Status $status Default: 'active'
 * @property-read array{
 *     id: numeric-string,
 *     title: string,
 *     status: string
 * } $originalDataArray
 */
final class Unit extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::Unit */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Unit;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    public function __get(string $name): mixed
    {
        return $this->originalDto->$name;
    }
}
