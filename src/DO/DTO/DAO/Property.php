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
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/**
 * @property-read ?DAO\Clinic clinic
 * @property-read bool isOnlineSigningUpAvailableForClinic
 */
final class Property extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    /** Default: '' */
    public string $name;
    public string $value;
    public ?string $title;
    /** @var ?positive-int Default: '0' (вместо него отдаем null) */
    public ?int $clinicId;

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

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->name = StringContainer::fromStringOrNull($originalData['property_name'])->string;
        $this->value = StringContainer::fromStringOrNull($originalData['property_value'])->string;
        $this->title = StringContainer::fromStringOrNull($originalData['property_title'])->string;
        $this->clinicId = IntContainer::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
    }

    /**
     * @throws VetmanagerApiGatewayResponseEmptyException Если нет такого в БД
     * @throws VetmanagerApiGatewayException
     */
    public static function getValueByClinicIdAndPropertyName(ApiGateway $api, int $clinicId, string $propertyName): ?string
    {
        $propertyOrNull = self::getByClinicIdAndPropertyName($api, $clinicId, $propertyName);
        return is_null($propertyOrNull) ? null : $propertyOrNull->value;
    }

    /**
     * @throws VetmanagerApiGatewayResponseEmptyException Если нет такого в БД
     * @throws VetmanagerApiGatewayException
     */
    public static function getByClinicIdAndPropertyName(ApiGateway $api, int $clinicId, string $propertyName): ?self
    {
        $filteredProperties = self::getByQueryBuilder(
            $api,
            (new Builder())
                ->where('property_name', $propertyName)
                ->where('clinic_id', (string)$clinicId),
            1
        );

        return !empty($filteredProperties) ? $filteredProperties[0] : null;
    }

    /** @return ApiRoute::Property */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Property;
    }

    /** @throws VetmanagerApiGatewayException */
    public static function isOnlineSigningUpAvailableForClinic(ApiGateway $apiGateway, int $clinicId): bool
    {
        $property = self::getByClinicIdAndPropertyName($apiGateway, $clinicId, 'service.appointmentWidget');
        return filter_var($property?->value, FILTER_VALIDATE_BOOL);
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
