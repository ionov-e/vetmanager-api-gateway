<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

/** Здесь перечислены имена моделей в роутах всех предусмотренных АПИ-запросов */
enum ApiRoute: string
{
    case Admission = 'admission';
    case Breed = 'breed';
    case Cassa = 'cassa';
    case CassaClose = 'cassaclose';
    case CassaRashod = 'cassarashod';
    case City = 'city';
    case CityType = 'cityType';
    case Client = 'client';
    case ClientPhone = 'clientPhone';
    case Clinic = 'clinics';
    case ClinicsToClients = 'clinicsToClients';
    case ClinicsToDocuments = 'clinicsToDocuments';
    case ClinicsToUsers = 'clinicsToUsers';
    case ClosingOfInvoice = 'closingOfInvoices';
    case ComboManualItem = 'comboManualItem';
    case ComboManualName = 'comboManualName';
    case Departments = 'departments';
    case DepartmentToDocument = 'departmentToDocument';
    case Diagnose = 'diagnoses';
    case DoctorsResponsible = 'doctorsResponsible';
    case FailedHook = 'failedHook';
    case FiscalRegister = 'fiscalRegister';
    case FiscalRegisterData = 'fiscalRegisterData';
    case Good = 'good';
    case GoodGroup = 'goodGroup';
    case GoodSaleParam = 'goodSaleParam';
    case Hospital = 'hospital';
    case HospitalBlock = 'hospitalBlock';
    case Invoice = 'invoice';
    case InvoiceDocument = 'invoiceDocument';
    case LastTime = 'lastTime';
    case MedicalCard = 'medicalCards';
    case MedicalCardsByClient = 'medicalCards/MedicalcardsDataByClient';
    case MedicalCardsVaccinations = 'medicalCards/Vaccinations';
    case PartyAccount = 'partyAccount';
    case PartyAccountDoc = 'partyAccountDoc';
    case Payment = 'payment';
    case Pet = 'pet';
    case PetType = 'petType';
    case Property = 'properties';
    case Report = 'report';
    case Role = 'role';
    case ServicePrice = 'servicePrice';
    case StoreDocument = 'storeDocument';
    case StoreDocumentOperation = 'storeDocumentOperation';
    case Store = 'stores';
    case Street = 'street';
    case Supplier = 'suppliers';
    case Timesheet = 'timesheet';
    case TimesheetType = 'timesheetTypes';
    case Unit = 'unit';
    case User = 'user';
    case UserCall = 'userCalls';
    case UserConfig = 'userConfig';
    case UserPosition = 'userPosition';

    /**
     * Ответ на АПИ-запросы приходят в виде JSON, в котором используется наименование модели.
     * Почти всегда этот ключ написан точно так же, как и название модели, используемом в роутах АПИ (перечислены выше).
     * Но есть исключения у некоторых запросов (т.е. имя модели в роуте и имя модели в ответе JSON отличаются)
     * @return value-of<ApiRoute>|value-of<DifferentModelResponseKey>
     */
    public function getApiModelResponseKey(): string
    {
        return match ($this) {
            self::MedicalCardsByClient, self::MedicalCardsVaccinations => (DifferentModelResponseKey::MedicalCards->value),
            default => $this->value
        };
    }
}
