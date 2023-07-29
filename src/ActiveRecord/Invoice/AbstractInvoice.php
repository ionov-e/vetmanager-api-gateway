<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

abstract class AbstractInvoice extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'invoice';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        switch ($name) {
//            case 'client':
//            case 'pet':
//            case 'petBreed':
//            case 'petType':
//            case 'user':
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
//                break;
//            case 'invoiceDocuments':   #TODO Only different from by ID
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsNotFull();
//        }
//
//        return match ($name) {
//            'client' => ClientOnly::fromSingleDtoArray($this->activeRecordFactory, $this->originalDataArray['client']),
//            'pet' => PetOnly::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $this->originalDataArray['pet']),
//            'petBreed' => !empty($this->originalDataArray['pet']['breed_data'])
//                ? BreedOnly::fromSingleDtoArray($this->activeRecordFactory, $this->originalDataArray['pet']['breed_data'])
//                : null,
//            'petType' => !empty($this->originalDataArray['pet']['pet_type_data'])
//                ? PetType::fromSingleDtoArray($this->activeRecordFactory, $this->originalDataArray['pet']['pet_type_data'])
//                : null,
//            'user' => User::fromSingleDtoArray($this->activeRecordFactory, $this->originalDataArray['doctor']),
//            'invoiceDocuments' => InvoiceDocument::fromMultipleDtosArrays(
//                $this->activeRecordFactory,
//                $this->originalDataArray['invoiceDocuments'],
//                Completeness::OnlyBasicDto
//                // На самом деле приходит еще и с полным goodSaleParam внутри. Но проигнорировал
//            ),
//            default => $this->originalDto->$name
//        };
//    }
}
