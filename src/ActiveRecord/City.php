<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read CityType $type */
final class City extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    public string $title;
    /** @var positive-int Default: 1 */
    public int $typeId;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "type_id": string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->typeId = IntContainer::fromStringOrNull($originalData['type_id'])->positiveInt;
    }

    /** @return ApiRoute::City */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::City;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => CityType::getById($this->apiGateway, $this->typeId),
            default => $this->$name,
        };
    }
}
