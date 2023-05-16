<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property array{
 *     "id": string,
 *     "title": string,
 *     "picture": string,
 *     "type": ?string,
 *     "breeds": list{array{
 *              "id": string,
 *              "title": string,
 *              "pet_type_id": string,
 *          }
 *     }
 * } $originalData 'breeds' массив только при GetById
 */
final class PetType extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::PetType */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::PetType;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'breeds':
                if ($this->sourceOfData == Source::GetById) {
                    return Breed::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalData['breeds'], Source::OnlyBasicDto);
                }
                #TODO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                // no break
            default:
                return $this->originalDto->$name;
        }
    }
}
