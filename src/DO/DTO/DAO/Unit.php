<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\Unit\Status;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Unit extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    public int $id;
    public string $title;
    /** Default: 'active' */
    public Status $status;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "status": string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->status = Status::from($originalData['status']);
    }

    /** @return ApiRoute::Unit */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Unit;
    }
}
