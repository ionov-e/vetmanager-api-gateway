<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\DTO\ComboManualName\NameEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class ComboManualName extends AbstractFacade implements AllRequestsInterface
{
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\ComboManualName\ComboManualNameOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
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
    public function getByParametersAsString(string $getParameters): array
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
    public function getByName(string $comboManualName): ActiveRecord\ComboManualName\ComboManualNamePlusComboManualItems
    {
        $comboManualNames = $this->getByQueryBuilder((new Builder())->where("name", $comboManualName), 1);
        return $comboManualNames[0];
    }

    /**
     * @param string $comboManualName Вместо строки можно пользоваться методом, принимающий Enum {@see getIdByNameAsEnum}
     * @throws VetmanagerApiGatewayException
     */
    public function getIdByNameAsString(string $comboManualName): int
    {
        return $this->getByName($comboManualName)->getId();
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