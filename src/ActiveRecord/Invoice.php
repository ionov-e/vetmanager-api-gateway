<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DTO\Enum\Invoice\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property positive-int $id;
 * @property ?positive-int $doctorId Ни в одной базе не нашел, чтобы было 0 или null
 * @property positive-int $clientId Ни в одной базе не нашел, чтобы было 0 или null
 * @property positive-int $petId Ни в одной базе не нашел, чтобы было 0 или null
 * @property string $description
 * @property float $percent Округляется до целых. Примеры: "0.0000000000", "-3.0000000000"
 * @property float $amount Примеры: "0.0000000000", "150.0000000000"
 * @property Status $status
 * @property DateTime $invoiceDate
 * @property ?positive-int $oldId
 * @property ?positive-int $night
 * @property float $increase Примеры: "0.0000000000"
 * @property float $discount Примеры: "0.0000000000", "3.0000000000"
 * @property ?positive-int $call DB default: '0' - переводим в null. В БД не видел 0/null
 * @property float $paidAmount Примеры: '0.0000000000', "240.0000000000"
 * @property DateTime $createDate DB default: '0000-00-00 00:00:00'
 * @property PaymentStatus $paymentStatus Default: 'none'
 * @property ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null
 * @property ?int $clinicId
 * @property ?positive-int
 * @property ?int $creatorId
 * @property ?positive-int Default: '0' - переводим в null. Редко вижу не 0
 * @property ?int $fiscalSectionId
 * @property array{
 *     id: string,
 *     doctor_id: ?numeric-string,
 *     client_id: numeric-string,
 *     pet_id: numeric-string,
 *     description: string,
 *     percent: ?string,
 *     amount: ?string,
 *     status: string,
 *     invoice_date: string,
 *     old_id: ?numeric-string,
 *     night: numeric-string,
 *     increase: ?string,
 *     discount: ?string,
 *     call: numeric-string,
 *     paid_amount: string,
 *     create_date: string,
 *     payment_status: string,
 *     clinic_id: numeric-string,
 *     creator_id: ?numeric-string,
 *     fiscal_section_id: numeric-string,
 *     client: array{
 *            id: string,
 *            address: string,
 *            home_phone: string,
 *            work_phone: string,
 *            note: string,
 *            type_id: ?string,
 *            how_find: ?string,
 *            balance: string,
 *            email: string,
 *            city: string,
 *            city_id: ?string,
 *            date_register: string,
 *            cell_phone: string,
 *            zip: string,
 *            registration_index: ?string,
 *            vip: string,
 *            last_name: string,
 *            first_name: string,
 *            middle_name: string,
 *            status: string,
 *            discount: string,
 *            passport_series: string,
 *            lab_number: string,
 *            street_id: string,
 *            apartment: string,
 *            unsubscribe: string,
 *            in_blacklist: string,
 *            last_visit_date: string,
 *            number_of_journal: string,
 *            phone_prefix: ?string,
 *      },
 *      pet: array{
 *             id: string,
 *             owner_id: ?string,
 *             type_id: ?string,
 *             alias: string,
 *             sex: ?string,
 *             date_register: string,
 *             birthday: ?string,
 *             note: string,
 *             breed_id: ?string,
 *             old_id: ?string,
 *             color_id: ?string,
 *             deathnote: ?string,
 *             deathdate: ?string,
 *             chip_number: string,
 *             lab_number: string,
 *             status: string,
 *             picture: ?string,
 *             weight: ?string,
 *             edit_date: string,
 *             pet_type_data?: array{
 *                      id: string,
 *                      title: string,
 *                      picture: string,
 *                      type: string
 *              },
 *              breed_data?: array{
 *                       id: string,
 *                       title: string,
 *                       pet_type_id: string
 *              }
 *       },
 *       doctor: array{
 *                  id: string,
 *                  last_name: string,
 *                  first_name: string,
 *                  middle_name: string,
 *                  login: string,
 *                  passwd: string,
 *                  position_id: ?string,
 *                  email: string,
 *                  phone: string,
 *                  cell_phone: string,
 *                  address: string,
 *                  role_id: ?string,
 *                  is_active: string,
 *                  calc_percents: string,
 *                  nickname: ?string,
 *                  last_change_pwd_date: string,
 *                  is_limited: string,
 *                  carrotquest_id: ?string,
 *                  sip_number: string,
 *                  user_inn: string,
 *       },
 *       invoiceDocuments: array<int,array{
 *                  id: string,
 *                  document_id: string,
 *                  good_id: string,
 *                  quantity: ?string,
 *                  price: ?string,
 *                  responsible_user_id: string,
 *                  is_default_responsible: string,
 *                  sale_param_id: string,
 *                  tag_id: string,
 *                  discount_type: ?string,
 *                  discount_document_id: ?string,
 *                  discount_percent: ?string,
 *                  default_price: ?string,
 *                  create_date: string,
 *                  discount_cause: ?string,
 *                  fixed_discount_id: string,
 *                  fixed_discount_percent: string,
 *                  fixed_increase_id: string,
 *                  fixed_increase_percent: string,
 *                  prime_cost: string,
 *                  party_info: array,
 *                  goodSaleParam: array{
 *                              id: string,
 *                              good_id: string,
 *                              price: ?string,
 *                              coefficient: string,
 *                              unit_sale_id: string,
 *                              min_price: ?string,
 *                              max_price: ?string,
 *                              barcode: ?string,
 *                              status: string,
 *                              clinic_id: string,
 *                              markup: string,
 *                              price_formation: ?string,
 *                              unitSale?: array{
 *                                      id: string,
 *                                      title: string,
 *                                      status: string
 *                              }
 *                     }
 *          }>
 *  } $originalDataArray
 * @property-read Client $client
 * @property-read Pet $pet
 * @property-read ?PetType $petType
 * @property-read ?Breed $petBreed
 * @property-read User $user
 * @property-read InvoiceDocument[] $invoiceDocuments
 */
final class Invoice extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use AllGetRequestsTrait;

    /** @return ApiModel::Invoice */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Invoice;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'client':
            case 'pet':
            case 'petBreed':
            case 'petType':
            case 'user':
            case 'invoiceDocuments':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'client' => Client::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['client']),
            'pet' => Pet::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['pet']),
            'petBreed' => !empty($this->originalDataArray['pet']['breed_data'])
                ? Breed::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['pet']['breed_data'])
                : null,
            'petType' => !empty($this->originalDataArray['pet']['pet_type_data'])
                ? PetType::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['pet']['pet_type_data'])
                : null,
            'user' => User::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['doctor']),
            'invoiceDocuments' => InvoiceDocument::fromMultipleDtosArrays($this->apiGateway, $this->originalDataArray['invoiceDocuments']),
            default => $this->originalDto->$name
        };
    }
}
