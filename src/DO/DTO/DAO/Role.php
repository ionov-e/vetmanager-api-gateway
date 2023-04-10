<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Role extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    public int $id;
    public string $name;
    /** Default: '0' */
    public bool $isSuper;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "name": string,
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->name = (string)$this->originalData['name'];
        $this->isSuper = (bool)$this->originalData['super'];
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Role;
    }
}