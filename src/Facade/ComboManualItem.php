<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ListEnum;
use VetmanagerApiGateway\DTO\ComboManualName\NameEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class ComboManualItem extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\ComboManualItem\ComboManualItemOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\ComboManualItem\ComboManualItemOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\ComboManualItem\AbstractComboManualItem
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\ComboManualItem\AbstractComboManualItem[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        return $this->protectedGetById(ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName::class, $id);
    }

    /** @return ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\ComboManualItem\ComboManualItemOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\ComboManualItem\ComboManualItemOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\ComboManualItem\ComboManualItemOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /**
     * @param int $typeId Например, значение из медкарты: {@see AbstractMedicalCard::admissionTypeId}
     * @param int $comboManualIdOfAdmissionType Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public function getByAdmissionTypeId(int $typeId, int $comboManualIdOfAdmissionType = 0): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        if ($comboManualIdOfAdmissionType) {
            return $this->getOneByValueAndComboManualId((string)$typeId, $comboManualIdOfAdmissionType);
        }

        return $this->getOneByValueAndComboManualName((string)$typeId, NameEnum::AdmissionType);
    }

    /**
     * @param int $resultId Скорее всего тут будет значение из медкарты: {@see AbstractMedicalCard::meetResultId}
     * @param int $comboManualIdOfAdmissionResult Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public function getByAdmissionResultId(int $resultId, int $comboManualIdOfAdmissionResult = 0): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        if ($comboManualIdOfAdmissionResult) {
            return $this->getOneByValueAndComboManualId((string)$resultId, $comboManualIdOfAdmissionResult);
        }

        return $this->getOneByValueAndComboManualName((string)$resultId, NameEnum::AdmissionResult);
    }

    /**
     * @param int $colorId Например: {@see PetOnlyDto::colorId}. По факту это value из таблицы combo_manual_items
     * @param int $comboManualIdOfPetColors Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public function getByPetColorId(int $colorId, int $comboManualIdOfPetColors = 0): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        if ($comboManualIdOfPetColors) {
            return $this->getOneByValueAndComboManualId((string)$colorId, $comboManualIdOfPetColors);
        }

        return $this->getOneByValueAndComboManualName((string)$colorId, NameEnum::PetColors);
    }

    /**
     * @param int $vaccineTypeId vaccine_type из таблицы vaccine_pets
     * @param int $comboManualIdOfVaccineTypes Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public function getByVaccineTypeId(int $vaccineTypeId, int $comboManualIdOfVaccineTypes = 0): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        if ($comboManualIdOfVaccineTypes) {
            return $this->getOneByValueAndComboManualId((string)$vaccineTypeId, $comboManualIdOfVaccineTypes);
        }

        return $this->getOneByValueAndComboManualName((string)$vaccineTypeId, NameEnum::VaccinationType);
    }

    /** @throws VetmanagerApiGatewayException Родительское исключение */
    public function getOneByValueAndComboManualName(string $comboManualValue, NameEnum $comboManualName): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        $comboManualId = $this->getComboManualIdFromComboManualName($comboManualName);

        return $this->getOneByValueAndComboManualId($comboManualValue, $comboManualId);
    }

    /** @throws VetmanagerApiGatewayException Родительское исключение */
    private function getComboManualIdFromComboManualName(NameEnum $comboManualName): int
    {
        return (new ComboManualName($this->activeRecordFactory))->getIdByNameAsEnum($comboManualName);
    }

    /** @throws VetmanagerApiGatewayException */
    private function getOneByValueAndComboManualId(string $comboManualValue, int $comboManualId): ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName
    {
        $comboManualItems = $this->getByQueryBuilder(
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualId)
                ->where('value', $comboManualValue),
            1
        );

        return $comboManualItems[0];
    }
}