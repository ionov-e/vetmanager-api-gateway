<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\ListEnum;
use VetmanagerApiGateway\DTO\ComboManualName\NameEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class ComboManualName extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\ComboManualName\ComboManualNameOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\ComboManualName\ComboManualNameOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\ComboManualName\AbstractComboManualName
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\ComboManualName\AbstractComboManualName[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        return $this->protectedGetById(ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems::class, $id);
    }

    /** @return ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByNameAsString(string $comboManualName): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        $comboManualNames = $this->getByQueryBuilder((new Builder())->where("name", $comboManualName), 1);
        return $comboManualNames[0];
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByNameAsEnum(NameEnum $comboManualName): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        return $this->getByNameAsString($comboManualName->value);
    }

    /**
     * @param string $comboManualName Вместо строки можно пользоваться методом, принимающий Enum {@see getIdByNameAsEnum}
     * @throws VetmanagerApiGatewayException
     */
    public function getIdByNameAsString(string $comboManualName): int
    {
        return $this->getByNameAsString($comboManualName)->getId();
    }

    /**
     * @param NameEnum $comboManualName Не нравится пользоваться Enum или не хватает значения - другой метод {@see getIdByNameAsString}
     * @throws VetmanagerApiGatewayException - родительское исключение
     */
    public function getIdByNameAsEnum(NameEnum $comboManualName): int
    {
        return $this->getIdByNameAsString($comboManualName->value);
    }
}