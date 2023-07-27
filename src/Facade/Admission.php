<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Admission extends AbstractFacade
{
    static public function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Admission::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Admission
    {
        return $this->protectedGetById(self::getDefaultActiveRecord(), $id);
    }

    /** @return ActiveRecord\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $id): array
    {
        return $this->protectedGetAll(ActiveRecord\ClientPlusTypeAndCity::class, $id);
    }


    /** Не возвращаются со статусом "удален"
     * @return self[]
     * @throws VetmanagerApiGatewayException
     */
    public static function getByClientId(ApiGateway $apiGateway, int $clientId, int $maxLimit = 100): array
    {
        return self::getByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('client_id', (string)$clientId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }

    /** Не возвращаются со статусом "удален"
     * @return self[]
     * @throws VetmanagerApiGatewayException
     */
    public static function getByPetId(ApiGateway $apiGateway, int $petId, int $maxLimit = 100): array
    {
        return self::getByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('patient_id', (string)$petId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }

}