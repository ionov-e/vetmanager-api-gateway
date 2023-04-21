<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Role extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    public string $name;
    /** Default: '0' */
    public bool $isSuper;

    /** @param array{
     *     "id": string,
     *     "name": string,
     *     "super": string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->name = StringContainer::fromStringOrNull($originalData['name'])->string;
        $this->isSuper = BoolContainer::fromStringOrNull($originalData['super'])->bool;
    }

    /** @return ApiRoute::Role */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Role;
    }
}
