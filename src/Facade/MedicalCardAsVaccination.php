<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class MedicalCardAsVaccination extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }

    /** @return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /**
     * @param string $additionalGetParameters Строку начинать без "?" или "&". Пример: limit=2&offset=1&sort=[{'property':'title','direction':'ASC'}]&filter=[{'property':'title', 'value':'some value'},
     * @return ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination[]
     * @throws VetmanagerApiGatewayException Родительское исключение
     */
    public function getByPetId(int $petId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        return $this->getByParametersAsString("pet_id={$petId}{$additionalGetParametersWithAmpersandOrNothing}");
    }
}