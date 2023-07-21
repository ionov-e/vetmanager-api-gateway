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
    public static function getById(ApiGateway $apiGateway, int $id): static
    {
        return static::fromSingleDtoArrayAsFromGetById(
            $apiGateway,
            $apiGateway->getWithId(static::getApiModel(), $id)
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayAsFromGetById(ApiGateway $apiGateway, array $originalDataArray): static
    {
        return static::fromSingleDtoArray($apiGateway, $originalDataArray, Completeness::Full);
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
        $instanceFromGetById = static::getById($this->apiGateway, $this->id);
        $this->originalDto = $instanceFromGetById->getPrimaryDto();
        $this->completenessLevel = Completeness::Full;
    }
}
