<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

abstract class AbstractMedicalCard extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'medicalCards';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        return match ($name) {
//            'pet' => ($this->completenessLevel == Completeness::Full)
//                ? PetOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['patient'])
//                : PetOnly::getById($this->activeRecordFactory, $this->petId),
//            'clinic' => $this->clinicId ? Clinic::getById($this->activeRecordFactory, $this->clinicId) : null,
//            'isOnlineSigningUpAvailableForClinic' => $this->clinicId ? Property::isOnlineSigningUpAvailableForClinic($this->activeRecordFactory, $this->clinicId) : null,
//            'admission' => $this->admissionId ? AdmissionOnly::getById($this->activeRecordFactory, $this->admissionId) : null,
//            'nextMeet' => $this->nextMeetId ? AdmissionOnly::getById($this->activeRecordFactory, $this->nextMeetId) : null,
//            'admissionType' => $this->admissionTypeId ? ComboManualItemOnly::getByAdmissionTypeId($this->activeRecordFactory, $this->admissionTypeId) : null,
//            'meetResult' => $this->meetResultId ? ComboManualItemOnly::getByAdmissionResultId($this->activeRecordFactory, $this->meetResultId) : null,
//            'invoice' => $this->invoiceId ? InvoiceOnly::getById($this->activeRecordFactory, $this->invoiceId) : null,
//            'user' => $this->userId ? User::getById($this->activeRecordFactory, $this->userId) : null,
//            default => $this->originalDto->$name
//        };
//    }
}
