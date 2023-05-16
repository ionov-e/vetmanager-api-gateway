<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

use VetmanagerApiGateway\DTO\AdmissionDto;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\DTO\ComboManualItemDto;
use VetmanagerApiGateway\DTO\ComboManualNameDto;
use VetmanagerApiGateway\DTO\GoodDto;
use VetmanagerApiGateway\DTO\GoodSaleParamDto;
use VetmanagerApiGateway\DTO\InvoiceDocumentDto;
use VetmanagerApiGateway\DTO\InvoiceDto;
use VetmanagerApiGateway\DTO\PetDto;
use VetmanagerApiGateway\DTO\PetTypeDto;
use VetmanagerApiGateway\DTO\UserDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

enum ApiModel
{
    case Admission;
    case Breed;
    case Cassa;
    case CassaClose;
    case CassaRashod;
    case City;
    case CityType;
    case Client;
    case ClientPhone;
    case Clinic;
    case ClinicsToClients;
    case ClinicsToDocuments;
    case ClinicsToUsers;
    case ClosingOfInvoice;
    case ComboManualItem;
    case ComboManualName;
    case Departments;
    case DepartmentToDocument;
    case Diagnose;
    case DoctorsResponsible;
    case FailedHook;
    case FiscalRegister;
    case FiscalRegisterData;
    case Good;
    case GoodGroup;
    case GoodSaleParam;
    case Hospital;
    case HospitalBlock;
    case Invoice;
    case InvoiceDocument;
    case LastTime;
    case MedicalCard;
    case MedicalCardsByClient;
    case MedicalCardsVaccinations;
    case PartyAccount;
    case PartyAccountDoc;
    case Payment;
    case Pet;
    case PetType;
    case Property;
    case Report;
    case Role;
    case ServicePrice;
    case StoreDocument;
    case StoreDocumentOperation;
    case Store;
    case Street;
    case Supplier;
    case Timesheet;
    case TimesheetType;
    case Unit;
    case User;
    case UserCall;
    case UserConfig;
    case UserPosition;

    /** @return class-string
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDtoClass(): string
    {
        return match ($this) {
            self::Admission => AdmissionDto::class,
            self::Breed => BreedDto::class,
            //            self::City => CityDto::class,
            //            self::CityType => CityTypeDto::class,
            self::Client => ClientDto::class,
            //            self::Clinic => ClinicDto::class,
            self::ComboManualItem => ComboManualItemDto::class,
            self::ComboManualName => ComboManualNameDto::class,
            self::Good => GoodDto::class,
            //            self::GoodGroup => GoodGroupDto::class,
            self::GoodSaleParam => GoodSaleParamDto::class,
            self::Invoice => InvoiceDto::class,
            self::InvoiceDocument => InvoiceDocumentDto::class,
            //            self::MedicalCard => MedicalCardDto::class,
            //            self::MedicalCardsByClient => MedicalCardsByClientDto::class,
            //            self::MedicalCardsVaccinations => MedicalCardsVaccinationsDto::class,
            self::Pet => PetDto::class,
            self::PetType => PetTypeDto::class,
            //            self::Property => PropertyDto::class,
            //            self::Role => RoleDto::class,
            //            self::Street => StreetDto::class,
            //            self::Unit => UnitDto::class,
            self::User => UserDto::class,
            //            self::UserPosition => UserPositionDto::class,
            default => throw new VetmanagerApiGatewayResponseException('To be implemented'),
        };
    }

    /** Здесь перечислены имена моделей в роутах всех предусмотренных АПИ-запросов */
    public function getRoute(): string
    {
        return match ($this) {
            self::Admission => 'admission',
            self::Breed => 'breed',
            self::Cassa => 'cassa',
            self::CassaClose => 'cassaclose',
            self::CassaRashod => 'cassarashod',
            self::City => 'city',
            self::CityType => 'cityType',
            self::Client => 'client',
            self::ClientPhone => 'clientPhone',
            self::Clinic => 'clinics',
            self::ClinicsToClients => 'clinicsToClients',
            self::ClinicsToDocuments => 'clinicsToDocuments',
            self::ClinicsToUsers => 'clinicsToUsers',
            self::ClosingOfInvoice => 'closingOfInvoices',
            self::ComboManualItem => 'comboManualItem',
            self::ComboManualName => 'comboManualName',
            self::Departments => 'departments',
            self::DepartmentToDocument => 'departmentToDocument',
            self::Diagnose => 'diagnoses',
            self::DoctorsResponsible => 'doctorsResponsible',
            self::FailedHook => 'failedHook',
            self::FiscalRegister => 'fiscalRegister',
            self::FiscalRegisterData => 'fiscalRegisterData',
            self::Good => 'good',
            self::GoodGroup => 'goodGroup',
            self::GoodSaleParam => 'goodSaleParam',
            self::Hospital => 'hospital',
            self::HospitalBlock => 'hospitalBlock',
            self::Invoice => 'invoice',
            self::InvoiceDocument => 'invoiceDocument',
            self::LastTime => 'lastTime',
            self::MedicalCard => 'medicalCards',
            self::MedicalCardsByClient => 'medicalCards/MedicalcardsDataByClient',
            self::MedicalCardsVaccinations => 'medicalCards/Vaccinations',
            self::PartyAccount => 'partyAccount',
            self::PartyAccountDoc => 'partyAccountDoc',
            self::Payment => 'payment',
            self::Pet => 'pet',
            self::PetType => 'petType',
            self::Property => 'properties',
            self::Report => 'report',
            self::Role => 'role',
            self::ServicePrice => 'servicePrice',
            self::StoreDocument => 'storeDocument',
            self::StoreDocumentOperation => 'storeDocumentOperation',
            self::Store => 'stores',
            self::Street => 'street',
            self::Supplier => 'suppliers',
            self::Timesheet => 'timesheet',
            self::TimesheetType => 'timesheetTypes',
            self::Unit => 'unit',
            self::User => 'user',
            self::UserCall => 'userCalls',
            self::UserConfig => 'userConfig',
            self::UserPosition => 'userPosition',
        };
    }

    /**
     * Ответ на АПИ-запросы приходят в виде JSON, в котором используется наименование модели.
     * Почти всегда этот ключ написан точно так же, как и название модели, используемом в роутах АПИ (перечислены выше).
     * Но есть исключения у некоторых запросов (т.е. имя модели в роуте и имя модели в ответе JSON отличаются)
     *
     * Например: Get-запрос на получение всех медкарт по ID клиента будет получаться по адресу:
     * /rest/api/MedicalCards/MedicalcardsDataByClient?client_id={{ID}}
     * А ответ придет в виде JSON: { "success": true, "data": { "medicalcards": [{...},{...}] } }.
     * То есть не совпадает "MedicalCards/MedicalcardsDataByClient" из url и "medicalcards" из ответа.
     *
     * @return value-of<ApiModel>|'medicalcards'
     */
    public function getResponseKey(): string
    {
        return match ($this) {
            self::MedicalCardsByClient, self::MedicalCardsVaccinations => 'medicalcards',
            default => $this->getRoute()
        };
    }
}
