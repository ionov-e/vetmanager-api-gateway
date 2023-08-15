<?php

namespace VetmanagerApiGateway\Unit\Facade;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\Admission\ListEnum;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Admission;

#[CoversClass(Admission::class)]
class AdmissionTest extends TestCase
{

    public static function dataProviderJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
    "id": "13",
    "admission_date": "2020-11-11 11:54:29",
    "description": "",
    "client_id": "17",
    "patient_id": "7",
    "user_id": "1",
    "type_id": "4",
    "admission_length": "00:15:00",
    "status": "accepted",
    "clinic_id": "1",
    "direct_direction": "0",
    "creator_id": "1",
    "create_date": "2020-11-11 10:42:56",
    "escorter_id": "0",
    "reception_write_channel": "vetmanager",
    "is_auto_create": "0",
    "invoices_sum": "100.0000000000",
    "pet": {
        "id": "7",
        "owner_id": "17",
        "type_id": "12",
        "alias": "Pet01",
        "sex": "unknown",
        "date_register": "2022-04-15 16:32:40",
        "birthday": null,
        "note": "",
        "breed_id": "771",
        "old_id": null,
        "color_id": "1",
        "deathnote": null,
        "deathdate": null,
        "chip_number": "",
        "lab_number": "vm7",
        "status": "alive",
        "picture": null,
        "weight": "20.0000000000",
        "edit_date": "2022-11-21 14:13:45",
        "pet_type_data": {
            "id": "12",
            "title": "грызуны2",
            "picture": "rodent",
            "type": "rodent"
        },
        "breed_data": {
            "id": "771",
            "title": "порода2",
            "pet_type_id": "12"
        }
    },
    "client": {
        "id": "17",
        "address": "",
        "home_phone": "71231234567",
        "work_phone": "",
        "note": "",
        "type_id": null,
        "how_find": null,
        "balance": "0.0000000000",
        "email": "sergey.laytaruk@gmail.com",
        "city": "",
        "city_id": "252",
        "date_register": "2020-11-09 16:11:38",
        "cell_phone": "7777777777",
        "zip": "",
        "registration_index": null,
        "vip": "0",
        "last_name": "Client01",
        "first_name": "Client01",
        "middle_name": "Client01",
        "status": "ACTIVE",
        "discount": "0",
        "passport_series": "",
        "lab_number": "",
        "street_id": "0",
        "apartment": "",
        "unsubscribe": "0",
        "in_blacklist": "0",
        "last_visit_date": "2021-09-07 12:36:37",
        "number_of_journal": "",
        "phone_prefix": "",
        "unisender_phone_pristavka": "38"
    },
    "doctor_data": {
        "id": "1",
        "last_name": "admin1",
        "first_name": "admin1",
        "middle_name": "admin1",
        "login": "admin",
        "passwd": "e12e2271792a4bfd3cd819ed544e33d9",
        "position_id": "8",
        "email": "admin1@local.com",
        "phone": "",
        "cell_phone": "",
        "address": "",
        "role_id": "7",
        "is_active": "1",
        "calc_percents": "1",
        "nickname": "admin",
        "youtrack_login": "",
        "youtrack_password": "",
        "last_change_pwd_date": "0000-00-00",
        "is_limited": "0",
        "carrotquest_id": "petstorys:1",
        "sip_number": "",
        "user_inn": ""
    },
    "admission_type_data": {
        "id": "4",
        "combo_manual_id": "1",
        "title": "Вторичный",
        "value": "4",
        "dop_param1": "00:00:00",
        "dop_param2": "",
        "dop_param3": "#0000FF",
        "is_active": "1"
    },
    "invoices": [
        {
            "id": "2",
            "doctor_id": "1",
            "client_id": "17",
            "pet_id": "7",
            "description": "",
            "percent": "0.0000000000",
            "amount": "100.0000000000",
            "status": "exec",
            "invoice_date": "2020-11-11 11:55:36",
            "old_id": null,
            "night": "0",
            "increase": "0.0000000000",
            "discount": "0.0000000000",
            "call": "0",
            "paid_amount": "100.0000000000",
            "create_date": "2020-11-11 11:54:03",
            "payment_status": "full",
            "clinic_id": "1",
            "creator_id": "1",
            "fiscal_section_id": "0",
            "d": "2020-11-11 11:54"
        }
    ],
    "wait_time": ""
}
EOF
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderJson')]
    public function testSpecificARFromSingleModelAsArray(string $json)
    {
        $modelAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecord = $apiGateway->getAdmission()->fromSingleModelAsArray($modelAsArray, ListEnum::PlusClientAndPetAndInvoicesAndTypeAndUser);
        $invoiceActiveRecord = $activeRecord->getInvoices()[0];
        $this->assertInstanceOf(InvoiceOnly::class, $invoiceActiveRecord);
        $activeRecordPetBreed = $activeRecord->getPetBreed();
        $this->assertInstanceOf(BreedOnly::class, $activeRecordPetBreed);
        $this->assertEquals(["id" => "771", "title" => "порода2", "pet_type_id" => "12"], $activeRecordPetBreed->getAsArray());
        $newActiveRecordPetBreed = $activeRecordPetBreed->setPetTypeId(13);
        $this->assertEquals(["pet_type_id" => "13"], $newActiveRecordPetBreed->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => "771", "title" => "порода2", "pet_type_id" => "13"], $newActiveRecordPetBreed->getAsArray());
        // Previous model hasn't changed:
        $this->assertEquals(["id" => "771", "title" => "порода2", "pet_type_id" => "12"], $activeRecordPetBreed->getAsArray());
        $this->assertEquals([], $activeRecordPetBreed->getAsArrayWithSetPropertiesOnly());
    }
}
