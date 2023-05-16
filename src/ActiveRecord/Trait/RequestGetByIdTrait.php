<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
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
        return self::fromSingleDtoArray($apiGateway, $originalData, Source::GetById);
    }

    /** Перезаписывает DTO {@see AbstractActiveRecord::$originalDto} и Source {@see AbstractActiveRecord::$sourceOfData}
     * текущего объекта на данные полученные по АПИ запросу используя ID
     * @throws VetmanagerApiGatewayException
     */
    public function fillCurrentObjectWithGetByIdDataIfItsNot(): void
    {
        if ($this->sourceOfData == Source::GetById) {
            return;
        }

        $instanceFromGetById = self::getById($this->apiGateway, $this->id);
        $this->originalDto = $instanceFromGetById->originalDto;
        $this->sourceOfData = Source::GetById;
    }
}
