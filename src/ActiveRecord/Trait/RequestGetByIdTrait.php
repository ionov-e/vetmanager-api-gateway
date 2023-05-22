<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @property int $id */
trait RequestGetByIdTrait
{
    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getById(ApiGateway $apiGateway, int $id): self
    {
        return self::fromSingleDtoArrayAsFromGetById(
            $apiGateway,
            $apiGateway->getWithId(self::getApiModel(), $id)
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayAsFromGetById(ApiGateway $apiGateway, array $originalDataArray): self
    {
        return self::fromSingleDtoArray($apiGateway, $originalDataArray, Completeness::Full);
    }

    /** Перезаписывает DTO {@see AbstractActiveRecord::$originalDto} и Source {@see AbstractActiveRecord::$completenessLevel}
     * текущего объекта на данные полученные по АПИ запросу используя ID, если объект получен иначе
     * @throws VetmanagerApiGatewayException
     */
    public function fillCurrentObjectWithGetByIdDataIfSourceIsNotFull(): void
    {
        if ($this->completenessLevel !== Completeness::Full) {
            $this->fillCurrentObjectWithGetByIdData();
        }
    }

    /** Перезаписывает DTO {@see AbstractActiveRecord::$originalDto} и Source {@see AbstractActiveRecord::$completenessLevel}
     * текущего объекта на данные полученные по АПИ запросу используя ID, если Source из 'минимального' DTO
     * @throws VetmanagerApiGatewayException
     */
    public function fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto(): void
    {
        if ($this->completenessLevel == Completeness::OnlyBasicDto) {
            $this->fillCurrentObjectWithGetByIdData();
        }
    }

    /** @throws VetmanagerApiGatewayException
     * @psalm-suppress PropertyTypeCoercion */
    private function fillCurrentObjectWithGetByIdData(): void
    {
        $instanceFromGetById = self::getById($this->apiGateway, $this->id);
        $this->originalDto = $instanceFromGetById->getAsDto();
        $this->completenessLevel = Completeness::Full;
    }
}
