<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Property extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\Property\Property> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Property\Property::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\Property\Property
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\Property\Property[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\Property\Property
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }

    /** @return ActiveRecord\Property\Property[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Property\Property::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Property\Property[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Property\Property::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Property\Property[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Property\Property::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\Property\Property[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Property\Property::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Property\Property
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Property\Property
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Property\Property
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByClinicIdAndPropertyName(int $clinicId, string $propertyName): ?ActiveRecord\Property\Property
    {
        $filteredProperties = $this->getByQueryBuilder(
            (new Builder())
                ->where('property_name', $propertyName)
                ->where('clinic_id', (string)$clinicId),
            1
        );

        return $filteredProperties[0] ?? null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getValueByClinicIdAndPropertyName(int $clinicId, string $propertyName): ?string
    {
        return $this->getByClinicIdAndPropertyName($clinicId, $propertyName)?->getValue();
    }

    /** @throws VetmanagerApiGatewayException */
    public function getIsOnlineSigningUpAvailableForClinic(int $clinicId): bool
    {
        $property = $this->getByClinicIdAndPropertyName($clinicId, 'service.appointmentWidget');
        return filter_var($property?->getValue(), FILTER_VALIDATE_BOOL);
    }
}
