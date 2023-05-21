<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\DTO\Enum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiString;

/**
 * @property-read ClientDto $originalDto
 * @property positive-int $id
 * @property string $address
 * @property string $homePhone
 * @property string $workPhone
 * @property string $note
 * @property ?positive-int $typeId
 * @property ?positive-int $howFind
 * @property float $balance Default: '0.0000000000'
 * @property string $email Default: ''
 * @property string $cityTitle
 * @property ?positive-int $cityId
 * @property ?DateTime $dateRegister
 * @property string $cellPhone
 * @property string $zip
 * @property string $registrationIndex
 * @property bool $isVip Default: False
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property Enum\Client\Status $status Default: Active
 * @property int $discount Default: 0
 * @property string $passportSeries
 * @property string $labNumber
 * @property ?int $streetId
 * @property string $apartment Default: ''
 * @property bool $isUnsubscribed Default: False
 * @property bool $isBlacklisted Default: False
 * @property ?DateTime $lastVisitDate В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null
 * @property string $numberOfJournal Default: ''
 * @property string $phonePrefix
 * @property-read  array{
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
 * @property-read ?City $city
 * @property-read string $typeTitle
 * @property-read Admission[] $admissions
 * @property-read MedicalCardByClient[] $medicalCards
 * @property-read Pet[] $petsAlive
 * @property-read ?Street $street
 * @property-read FullName $fullName
 * */
final class Client extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::Client */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Client;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'city':
            case 'typeTitle':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'city' => !empty($originalData['city_data'])
                ? City::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['city_data'])
                : null,
            'typeTitle' => ApiString::fromStringOrNull(
                $this->originalDataArray['client_type_data']['title'] ?? ''
            )->string,
            'admissions' => Admission::getByClientId($this->apiGateway, $this->id),
            'medicalCards' => MedicalCardByClient::getByClientId($this->apiGateway, $this->id),
            'petsAlive' => $this->getPetsAlive(),
            'street' => $this->streetId ? Street::getById($this->apiGateway, $this->streetId) : null,
            'fullName' => new FullName(
                $this->originalDataArray['first_name'],
                $this->originalDataArray['middle_name'],
                $this->originalDataArray['last_name']
            ),
            default => $this->originalDto->$name
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
                ->where('status', Enum\Pet\Status::Alive->value)
        );

        return Pet::fromApiResponseArray($this->apiGateway, $pets);
    }
}
