<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\Pet\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Client extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public ?City $city;
    public string $typeTitle;

    /** @param array{
     *   "id": string,
     *   "address": string,
     *   "home_phone": string,
     *   "work_phone": string,
     *   "note": string,
     *   "type_id": ?string,
     *   "how_find": ?string,
     *   "balance": string,
     *   "email": string,
     *   "city": string,
     *   "city_id": ?string,
     *   "date_register": string,
     *   "cell_phone": string,
     *   "zip": string,
     *   "registration_index": ?string,
     *   "vip": string,
     *   "last_name": string,
     *   "first_name": string,
     *   "middle_name": string,
     *   "status": string,
     *   "discount": string,
     *   "passport_series": string,
     *   "lab_number": string,
     *   "street_id": string,
     *   "apartment": string,
     *   "unsubscribe": string,
     *   "in_blacklist": string,
     *   "last_visit_date": string,
     *   "number_of_journal": string,
     *   "phone_prefix": ?string,
     *   "city_data"?: array {
     *      "id": string,
     *      "title": string,
     *      "type_id": string
     *      },
     *   "client_type_data"?: array {
     *      "id": string,
     *      "title": string
     *      }
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

    /** @return ApiModel::Client */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Client;
    }


    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'admissions' => AdmissionFromGetAll::getByClientId($this->apiGateway, $this->id),
            'medcards' => MedicalCardsByClient::getByClientId($this->apiGateway, $this->id),
            'petsAlive' => $this->getPetsAlive(),
            'street' => $this->streetId ? Street::getById($this->apiGateway, $this->streetId) : null,
            'city' => $this->cityId ? City::getById($this->apiGateway, $this->cityId) : null,
            'fullName' => new FullName(
                $this->originalData['first_name'],
                $this->originalData['middle_name'],
                $this->originalData['last_name']
            ),
            default => $this->$name
        };
    }

    /** @return Pet[]
     * @throws VetmanagerApiGatewayException
     */
    private function getPetsAlive(): array
    {
        $pets = $this->apiGateway->getWithQueryBuilder(
            ApiModel::Pet,
            (new Builder())
                ->where('owner_id', (string)$this->id)
                ->where('status', Status::Alive->value)
        );

        return Pet::fromApiResponseArray($this->apiGateway, $pets);
    }
}
