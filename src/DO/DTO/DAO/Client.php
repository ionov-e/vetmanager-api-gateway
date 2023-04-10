<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Client extends DTO\Client implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public ?City $city;
    public ?string $typeTitle;
    /** @var array{
     *      "id": string,
     *      "address": string,
     *      "home_phone": string,
     *      "work_phone": string,
     *      "note": string,
     *      "type_id": ?string,
     *      "how_find": ?string,
     *      "balance": string,
     *      "email": string,
     *      "city": string,
     *      "city_id": ?string,
     *      "date_register": string,
     *      "cell_phone": string,
     *      "zip": string,
     *      "registration_index": ?string,
     *      "vip": string,
     *      "last_name": string,
     *      "first_name": string,
     *      "middle_name": string,
     *      "status": string,
     *      "discount": string,
     *      "passport_series": string,
     *      "lab_number": string,
     *      "street_id": string,
     *      "apartment": string,
     *      "unsubscribe": string,
     *      "in_blacklist": string,
     *      "last_visit_date": string,
     *      "number_of_journal": string,
     *      "phone_prefix": ?string,
     *      ?"city_data": array {
     *           "id": string,
     *           "title": string,
     *           "type_id": string
     *           },
     *      ?"client_type_data": array {
     *           "id": string,
     *           "title": string
     *           }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->city = $this->originalData['city_data'] ? DAO\City::fromSingleObjectContents($this->apiGateway, $this->originalData['city_data']) : null;

        $typeTitle = $this->originalData['client_type_data']['title'] ?? null;
        $this->typeTitle = $typeTitle ? (string)$typeTitle : null;
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Client;
    }
}
