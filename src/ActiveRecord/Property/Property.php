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
