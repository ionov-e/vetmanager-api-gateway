<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class User extends DTO\User implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Предзагружен (если существует). Отдельного АПИ-запроса не будет */
    public ?DAO\Role $role;
    /** Предзагружен (если существует). Отдельного АПИ-запроса не будет */
    public ?UserPosition $position;
    /** @var array{
     *     "id": string,
     *     "last_name": string,
     *     "first_name": string,
     *     "middle_name": string,
     *     "login": string,
     *     "passwd": string,
     *     "position_id": ?string,
     *     "email": string,
     *     "phone": string,
     *     "cell_phone": string,
     *     "address": string,
     *     "role_id": ?string,
     *     "is_active": string,
     *     "calc_percents": string,
     *     "nickname": ?string ,
     *     "youtrack_login": string,
     *     "youtrack_password": string,
     *     "last_change_pwd_date": string,
     *     "is_limited": string,
     *     "carrotquest_id": ?string,
     *     "sip_number": string,
     *     "user_inn": string,
     *     ?"position": array{
     *           "id": string,
     *           "title": string,
     *           "admission_length": string
     *     },
     *     ?"role": array{
     *           "id": string,
     *           "name": string,
     *           "super": string
     *     }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->role = $this->originalData['role_id'] ? DAO\Role::fromSingleObjectContents($this->apiGateway, $this->originalData['role']) : null;
        $this->position = $this->originalData['position_id'] ? DAO\UserPosition::fromSingleObjectContents($this->apiGateway, $this->originalData['position']) : null;
    }

    /** @return ApiRoute::User */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::User;
    }
}
