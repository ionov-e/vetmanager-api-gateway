<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DTO\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Role extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
