<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\Unit\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Unit extends AbstractActiveRecord implements AllGetRequestsInterface
{

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
    public function __construct(ApiGateway $apiGateway, array $originalData)
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
