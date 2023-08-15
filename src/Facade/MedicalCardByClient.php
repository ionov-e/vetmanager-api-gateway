<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class MedicalCardByClient extends AbstractFacade
{
    /** @return class-string<ActiveRecord\MedicalCardByClient\MedicalCardByClient> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\MedicalCardByClient\MedicalCardByClient::class;
    }
    
    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\MedicalCardByClient\MedicalCardByClient
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\MedicalCardByClient\MedicalCardByClient[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @return ActiveRecord\MedicalCardByClient\MedicalCardByClient[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\MedicalCardByClient\MedicalCardByClient::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\MedicalCardByClient\MedicalCardByClient
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\MedicalCardByClient\MedicalCardByClient
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\MedicalCardByClient\MedicalCardByClient
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /**
     * @param string $additionalGetParameters Строку начинать без "?" или "&". Пример: limit=2&offset=1&sort=[{'property':'title','direction':'ASC'}]&filter=[{'property':'title', 'value':'some value'},
     * @return ActiveRecord\MedicalCardByClient\MedicalCardByClient[]
     * @throws VetmanagerApiGatewayException Родительское исключение
     */
    public function getByClientId(int $clientId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        return $this->getByParametersAsString("client_id={$clientId}{$additionalGetParametersWithAmpersandOrNothing}");
    }
}