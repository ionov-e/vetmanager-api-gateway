<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestGetByIdTrait
{
    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getById(ApiGateway $apiGateway, int $id): self
    {
        return self::fromSingleDtoArrayUsingGetById(
            $apiGateway,
            $apiGateway->getWithId(self::getApiModel(), $id)
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayUsingGetById(ApiGateway $apiGateway, array $originalData): self
    {
        return self::fromSingleDtoArray($apiGateway, $originalData, Completeness::Full);
    }

    /** Перезаписывает DTO {@see AbstractActiveRecord::$originalDto} и Source {@see AbstractActiveRecord::$sourceOfData}
     * текущего объекта на данные полученные по АПИ запросу используя ID, если объект получен иначе
     * @throws VetmanagerApiGatewayException
     */
    public function fillCurrentObjectWithGetByIdDataIfSourceIsDifferent(): void
    {
        if ($this->sourceOfData !== Completeness::Full) {
            $this->fillCurrentObjectWithGetByIdData();
        }
    }

    /** Перезаписывает DTO {@see AbstractActiveRecord::$originalDto} и Source {@see AbstractActiveRecord::$sourceOfData}
     * текущего объекта на данные полученные по АПИ запросу используя ID, если Source из 'минимального' DTO
     * @throws VetmanagerApiGatewayException
     */
    public function fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto(): void
    {
        if ($this->sourceOfData == Completeness::OnlyBasicDto) {
            $this->fillCurrentObjectWithGetByIdData();
        }
    }

    /** @throws VetmanagerApiGatewayException */
    private function fillCurrentObjectWithGetByIdData(): void
    {
        $instanceFromGetById = self::getById($this->apiGateway, $this->id);
        $this->originalDto = $instanceFromGetById->getAsDto();
        $this->originalDataArray = $instanceFromGetById->getAsOriginalDataArray();
        $this->sourceOfData = Completeness::Full;
    }
}
