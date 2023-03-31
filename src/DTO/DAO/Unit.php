<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DTO\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\DTO\Enum\Unit\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Unit extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
