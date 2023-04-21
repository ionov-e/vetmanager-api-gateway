<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/** @property-read ?DAO\Clinic $clinic */
final class Property extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    public int $id;
    /** Default: '' */
    public string $name;
    public string $value;
    public ?string $title;
    /** Default: '0' */
    public int $clinicId;

    /** @param array{
     *     "id": string,
     *     "property_name": string,
     *     "property_value": string,
     *     "property_title": ?string,
     *     "clinic_id": string
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$originalData['id'];
        $this->name = (string)$originalData['property_name'];
        $this->value = (string)$originalData['property_value'];
        $this->title = $originalData['property_title'] ? (string)$originalData['property_title'] : null;
        $this->clinicId = (int)$originalData['clinic_id'];
    }

    /**
     * @throws VetmanagerApiGatewayResponseEmptyException Если нет такого в БД
     * @throws VetmanagerApiGatewayException
     */
    public static function getByClinicIdAndPropertyName(ApiGateway $api, int $clinicId, string $propertyName): self
    {
        $filteredProperties = self::getByPagedQuery(
            $api,
            (new Builder())
                ->where('property_name', $propertyName)
                ->where('clinic_id', (string)$clinicId)
                ->top(1)
        );

        return $filteredProperties[0];
    }

    /** @return ApiRoute::Property */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Property;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'clinic' => $this->clinicId ? DAO\Clinic::getById($this->apiGateway, $this->clinicId) : null,
            default => $this->$name,
        };
    }
}
