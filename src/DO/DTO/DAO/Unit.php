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
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Unit extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    public int $id;
    public string $title;
    /** Default: 'active' */
    public Status $status;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "status": string,
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->status = Status::from($this->originalData['status']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Unit;
    }
}