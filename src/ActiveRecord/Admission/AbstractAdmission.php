<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\Breed;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\ActiveRecord\User\UserOnly;
use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDto;
use VetmanagerApiGateway\DTO\Admission\StatusEnum;

/**
 * @property-read AdmissionOnlyDto $originalDto
 * @property positive-int $id
 * @property ?DateTime $date Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - переводится в null
 * @property string $description Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев"
 * @property ?positive-int $clientId
 * @property ?positive-int $petId
 * @property ?positive-int $userId
 * @property ?positive-int $typeId
 * @property ?DateInterval $admissionLength Примеры: "00:15:00", "00:00:00" (последнее перевожу в null)
 * @property ?StatusEnum $status
 * @property ?positive-int $clinicId В БД встречается "0" - переводим в null
 * @property bool $isDirectDirection Насколько я понял, означает: 'Прием без планирования'
 * @property ?positive-int $creatorId
 * @property ?DateTime $createDate
 * @property ?int $escortId Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see UserOnly}. Какой-то врач-помощник что ли. Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать
 * @property string $receptionWriteChannel Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null)
 * @property bool $isAutoCreate
 * @property float $invoicesSum Default: 0.0000000000
 * @property-read array{
 *          id: numeric-string,
 *          admission_date: string,
 *          description: string,
 *          client_id: numeric-string,
 *          patient_id: numeric-string,
 *          user_id: numeric-string,
 *          type_id: numeric-string,
 *          admission_length: string,
 *          status: ?string,
 *          clinic_id: numeric-string,
 *          direct_direction: string,
 *          creator_id: numeric-string,
 *          create_date: string,
 *          escorter_id: ?numeric-string,
 *          reception_write_channel: ?string,
 *          is_auto_create: string,
 *          invoices_sum: string,
 *          client: array{
 *                      id: string,
 *                      address: string,
 *                      home_phone: string,
 *                      work_phone: string,
 *                      note: string,
 *                      type_id: ?string,
 *                      how_find: ?string,
 *                      balance: string,
 *                      email: string,
 *                      city: string,
 *                      city_id: ?string,
 *                      date_register: string,
 *                      cell_phone: string,
 *                      zip: string,
 *                      registration_index: ?string,
 *                      vip: string,
 *                      last_name: string,
 *                      first_name: string,
 *                      middle_name: string,
 *                      status: string,
 *                      discount: string,
 *                      passport_series: string,
 *                      lab_number: string,
 *                      street_id: string,
 *                      apartment: string,
 *                      unsubscribe: string,
 *                      in_blacklist: string,
 *                      last_visit_date: string,
 *                      number_of_journal: string,
 *                      phone_prefix: ?string
 *          },
 *          pet?: array{
 *                      id: string,
 *                      owner_id: ?string,
 *                      type_id: ?string,
 *                      alias: string,
 *                      sex: ?string,
 *                      date_register: string,
 *                      birthday: ?string,
 *                      note: string,
 *                      breed_id: ?string,
 *                      old_id: ?string,
 *                      color_id: ?string,
 *                      deathnote: ?string,
 *                      deathdate: ?string,
 *                      chip_number: string,
 *                      lab_number: string,
 *                      status: string,
 *                      picture: ?string,
 *                      weight: ?string,
 *                      edit_date: string,
 *                      pet_type_data?: array{}|array{
 *                              id: string,
 *                              title: string,
 *                              picture: string,
 *                              type: ?string
 *                      },
 *                      breed_data?: array{
 *                              id: string,
 *                              title: string,
 *                              pet_type_id: string
 *                      }
 *          },
 *          doctor_data?: array{
 *                      id: string,
 *                      last_name: string,
 *                      first_name: string,
 *                      middle_name: string,
 *                      login: string,
 *                      passwd: string,
 *                      position_id: ?string,
 *                      email: string,
 *                      phone: string,
 *                      cell_phone: string,
 *                      address: string,
 *                      role_id: ?string,
 *                      is_active: string,
 *                      calc_percents: string,
 *                      nickname: ?string,
 *                      last_change_pwd_date: string,
 *                      is_limited: string,
 *                      carrotquest_id: ?string,
 *                      sip_number: string,
 *                      user_inn: string
 *          },
 *          admission_type_data?: array{
 *                      id: string,
 *                      combo_manual_id: string,
 *                      title: string,
 *                      value: string,
 *                      dop_param1: string,
 *                      dop_param2: string,
 *                      dop_param3: string,
 *                      is_active: string
 *          },
 *          wait_time?: string,
 *          invoices?: array<int, array{
 *                              id: string,
 *                              doctor_id: ?string,
 *                              client_id: string,
 *                              pet_id: string,
 *                              description: string,
 *                              percent: ?string,
 *                              amount: ?string,
 *                              status: string,
 *                              invoice_date: string,
 *                              old_id: ?string,
 *                              night: string,
 *                              increase: ?string,
 *                              discount: ?string,
 *                              call: string,
 *                              paid_amount: string,
 *                              create_date: string,
 *                              payment_status: string,
 *                              clinic_id: string,
 *                              creator_id: ?string,
 *                              fiscal_section_id: string,
 *                              d: string
 *           }>
 *     } $originalDataArray Массив, полученный по ID отличается от Get All лишь наличием двух дополнительных DTO: 1) {@see self::type} из элемента admission_type_data; 2) {@see self::user} из элемента doctor_data
 * @property-read string $waitTime
 * @property-read ClientOnly $client
 * @property-read ?PetOnly $pet Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null
 * @property-read ?PetTypeOnly $petType
 * @property-read ?Breed $petBreed
 * @property-read InvoiceOnly[] $invoices Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется. При других запросах такого элемента нет
 * @property-read ?UserOnly $user
 * @property-read ?ComboManualItemOnly $type
 * @property-read ?Clinic $clinic
 * @property-read AdmissionOnly[] $admissionsOfPet
 * @property-read AdmissionOnly[] $admissionsOfOwner
 */
abstract class AbstractAdmission extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'admission';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        switch ($name) {
//            case 'user':
//            case 'type':
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsNotFull();
//                break;
//            case 'client':
//            case 'pet':
//            case 'petType':
//            case 'petBreed':
//            case 'waitTime':
//            case 'invoices':
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
//        }
//
//        return match ($name) {
//            'user' => !empty($this->originalDataArray['doctor_data'])
//                ? User::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['doctor_data'])
//                : null,
//            'type' => !empty($this->originalDataArray['admission_type_data'])
//                ? ComboManualItem::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['admission_type_data'])
//                : null,
//            'client' => ClientOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['client']),
//            'pet' => !empty($this->originalDataArray['pet'])
//                ? PetOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['pet'])
//                : null,
//            'petType' => !empty($this->originalDataArray['pet']['pet_type_data'])
//                ? PetType::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['pet']['pet_type_data'])
//                : null,
//            'petBreed' => !empty($this->originalDataArray['pet']['breed_data']) /** @psalm-suppress DocblockTypeContradiction */
//                ? Breed::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['pet']['breed_data'])
//                : null,
//            'waitTime' => ApiString::fromStringOrNull($this->originalDataArray['wait_time'] ?? '')->getStringEvenIfNullGiven(),
//            'invoices' => Invoice::fromMultipleDtosArrays($this->activeRecordFactory, $this->originalDataArray['invoices'] ?? [], Completeness::OnlyBasicDto),
//            'clinic' => $this->clinicId ? Clinic::getById($this->activeRecordFactory, $this->clinicId) : null,
//            'admissionsOfPet' => $this->petId ? self::getByPetId($this->activeRecordFactory, $this->petId) : [],
//            'admissionsOfOwner' => $this->clientId ? self::getByClientId($this->activeRecordFactory, $this->clientId) : [],
//            default => $this->originalDto->$name
//        };
//    }
}
