<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Invoice extends DTO\Invoice implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    public DTO\Client $client;
    public DTO\Pet $pet;
    public DTO\PetType $petType;
    public DTO\Breed $petBreed;
    public DTO\User $doctor;
    /** @var DTO\InvoiceDocument[] */
    public array $invoiceDocuments;

    /** @var array{
     *     "id": string,
     *     "doctor_id": ?string,
     *     "client_id": string,
     *     "pet_id": string,
     *     "description": string,
     *     "percent": ?string,
     *     "amount": ?string,
     *     "status": string,
     *     "invoice_date": string,
     *     "old_id": ?string,
     *     "night": string,
     *     "increase": ?string,
     *     "discount": ?string,
     *     "call": string,
     *     "paid_amount": string,
     *     "create_date": string,
     *     "payment_status": string,
     *     "clinic_id": string,
     *     "creator_id": ?string,
     *     "fiscal_section_id": string,
     *     "client": array{
     *            "id": string,
     *            "address": string,
     *            "home_phone": string,
     *            "work_phone": string,
     *            "note": string,
     *            "type_id": ?string,
     *            "how_find": ?string,
     *            "balance": string,
     *            "email": string,
     *            "city": string,
     *            "city_id": ?string,
     *            "date_register": string,
     *            "cell_phone": string,
     *            "zip": string,
     *            "registration_index": ?string,
     *            "vip": string,
     *            "last_name": string,
     *            "first_name": string,
     *            "middle_name": string,
     *            "status": string,
     *            "discount": string,
     *            "passport_series": string,
     *            "lab_number": string,
     *            "street_id": string,
     *            "apartment": string,
     *            "unsubscribe": string,
     *            "in_blacklist": string,
     *            "last_visit_date": string,
     *            "number_of_journal": string,
     *            "phone_prefix": ?string,
     *      },
     *      "pet": array{
     *             "id": string,
     *             "owner_id": ?string,
     *             "type_id": ?string,
     *             "alias": string,
     *             "sex": ?string,
     *             "date_register": string,
     *             "birthday": ?string,
     *             "note": string,
     *             "breed_id": ?string,
     *             "old_id": ?string,
     *             "color_id": ?string,
     *             "deathnote": ?string,
     *             "deathdate": ?string,
     *             "chip_number": string,
     *             "lab_number": string,
     *             "status": string,
     *             "picture": ?string,
     *             "weight": ?string,
     *             "edit_date": string,
     *             "pet_type_data": array{
     *                      "id": string,
     *                      "title": string,
     *                      "picture": string,
     *                      "type": string
     *              },
     *              "breed_data": array{
     *                       "id": string,
     *                       "title": string,
     *                       "pet_type_id": string
     *              }
     *       },
     *       "doctor": array{
     *                  "id": string,
     *                  "last_name": string,
     *                  "first_name": string,
     *                  "middle_name": string,
     *                  "login": string,
     *                  "passwd": string,
     *                  "position_id": ?string,
     *                  "email": string,
     *                  "phone": string,
     *                  "cell_phone": string,
     *                  "address": string,
     *                  "role_id": ?string,
     *                  "is_active": string,
     *                  "calc_percents": string,
     *                  "nickname": ?string ,
     *                  "youtrack_login": string,
     *                  "youtrack_password": string,
     *                  "last_change_pwd_date": string,
     *                  "is_limited": string,
     *                  "carrotquest_id": ?string,
     *                  "sip_number": string,
     *                  "user_inn": string,
     *       },
     *       "invoiceDocuments": array<int,array{
     *                  "id": string,
     *                  "document_id": string,
     *                  "good_id": string,
     *                  "quantity": ?string,
     *                  "price": ?string,
     *                  "responsible_user_id": string,
     *                  "is_default_responsible": string,
     *                  "sale_param_id": string,
     *                  "tag_id": string,
     *                  "discount_type": ?string,
     *                  "discount_document_id": ?string,
     *                  "discount_percent": ?string,
     *                  "default_price": ?string,
     *                  "create_date": string,
     *                  "discount_cause": ?string,
     *                  "fixed_discount_id": string,
     *                  "fixed_discount_percent": string,
     *                  "fixed_increase_id": string,
     *                  "fixed_increase_percent": string,
     *                  "prime_cost": string,
     *                  "party_info": array,
     *                  "goodSaleParam": array{
     *                              "id": string,
     *                              "good_id": string,
     *                              "price": ?string,
     *                              "coefficient": string,
     *                              "unit_sale_id": string,
     *                              "min_price": ?string,
     *                              "max_price": ?string,
     *                              "barcode": ?string,
     *                              "status": string,
     *                              "clinic_id": string,
     *                              "markup": string,
     *                              "price_formation": ?string,
     *                              "unitSale": array{
     *                                      "id": string,
     *                                      "title": string,
     *                                      "status": string
     *                              }
     *                     }
     *          }>
     *  }
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->client = DTO\Client::fromSingleObjectContents($this->apiGateway, $this->originalData['client']);
        $this->pet = DTO\Pet::fromSingleObjectContents($this->apiGateway, $this->originalData['pet']);
        $this->petBreed = DTO\Breed::fromSingleObjectContents($this->apiGateway, $this->originalData['pet']['breed_data']);
        $this->petType = DTO\PetType::fromSingleObjectContents($this->apiGateway, $this->originalData['pet']['pet_type_data']);
        $this->doctor = DTO\User::fromSingleObjectContents($this->apiGateway, $this->originalData['doctor']);
        $this->invoiceDocuments = DTO\InvoiceDocument::fromMultipleObjectsContents(
            $this->apiGateway,
            $this->originalData['invoiceDocuments']
        );
    }

    /** @return ApiRoute::Invoice */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Invoice;
    }
}
