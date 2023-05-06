<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\BasicDAOTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Client extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public ?City $city;
    public string $typeTitle;

    /** @param array{
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
     *      "city_data"?: array {
     *           "id": string,
     *           "title": string,
     *           "type_id": string
     *           },
     *      "client_type_data"?: array {
     *           "id": string,
     *           "title": string
     *           }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->city = !empty($originalData['city_data'])
            ? ActiveRecord\City::fromSingleObjectContents($this->apiGateway, $originalData['city_data'])
            : null;
        $this->typeTitle = StringContainer::fromStringOrNull(
            $originalData['client_type_data']['title'] ?? ''
        )->string;
    }

    /** @return ApiRoute::Client */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Client;
    }
}
