<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Property;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\DTO\Property\PropertyOnlyDto;

/**
 * @property-read PropertyOnlyDto $originalDto
 * @property positive-int $id
 * @property string $name Default: ''
 * @property string $value
 * @property ?string $title
 * @property ?positive-int $clinicId
 * @property-read array{
 *     id: string,
 *     property_name: string,
 *     property_value: string,
 *     property_title: ?string,
 *     clinic_id: string
 * } $originalDataArray
 * @property-read ?Clinic $clinic
 * @property-read ?bool $isOnlineSigningUpAvailableForClinic null возвращается, если вдруг clinic_id = null
 */
final class Property extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'properties';
    }

    public static function getDtoClass(): string
    {
        return PropertyOnlyDto::class;
    }
//    /**
//     * @throws VetmanagerApiGatewayResponseEmptyException Если нет такого в БД
//     * @throws VetmanagerApiGatewayException
//     */
//    public static function getByClinicIdAndPropertyName(ApiGateway $apiGateway, int $clinicId, string $propertyName): ?self
//    {
//        $filteredProperties = self::getByQueryBuilder(
//            $apiGateway,
//            (new Builder())
//                ->where('property_name', $propertyName)
//                ->where('clinic_id', (string)$clinicId),
//            1
//        );
//
//        return $filteredProperties[0] ?? null;
//    }

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

//    /**
//     * @throws VetmanagerApiGatewayResponseEmptyException Если нет такого в БД
//     * @throws VetmanagerApiGatewayException
//     */
//    public static function getValueByClinicIdAndPropertyName(ApiGateway $apiGateway, int $clinicId, string $propertyName): ?string
//    {
//        return self::getByClinicIdAndPropertyName($apiGateway, $clinicId, $propertyName)?->value;
//    }
//
//    /** @throws VetmanagerApiGatewayException */
//    public static function isOnlineSigningUpAvailableForClinic(ApiGateway $apiGateway, int $clinicId): bool
//    {
//        $property = self::getByClinicIdAndPropertyName($apiGateway, $clinicId, 'service.appointmentWidget');
//        return filter_var($property?->value, FILTER_VALIDATE_BOOL);
//    }
//
//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        return match ($name) {
//            'clinic' => $this->clinicId ? Clinic::getById($this->activeRecordFactory, $this->clinicId) : null,
//            'isOnlineSigningUpAvailableForClinic' => $this->clinicId ? self::isOnlineSigningUpAvailableForClinic($this->activeRecordFactory, $this->clinicId) : null,
//            default => $this->originalDto->$name
//        };
//    }
}
