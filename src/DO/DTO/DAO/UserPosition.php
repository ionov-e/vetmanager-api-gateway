<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use DateInterval;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateIntervalContainer;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class UserPosition extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    public int $id;
    public string $title;
    /** Default: '00:30:00'. Type in DB: 'time'. Null if '00:00:00' */
    public ?DateInterval $admissionLength;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "admission_length": string,
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->admissionLength = (DateIntervalContainer::fromStringHMS($this->originalData['admission_length']))->dateIntervalNullable;
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::UserPosition;
    }
}
