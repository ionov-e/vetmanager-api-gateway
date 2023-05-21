<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateInterval;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\UserPositionDto;

/**
 * @property-read UserPositionDto $originalDto
 * @property int $id
 * @property string $title
 * @property ?DateInterval $admissionLength Default: '00:30:00'
 * @property-read array{
 *     "id": string,
 *     "title": string,
 *     "admission_length": string,
 * } $originalData
 */
final class UserPosition extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::UserPosition */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::UserPosition;
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
