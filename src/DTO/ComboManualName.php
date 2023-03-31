<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\ComboManualName $self */
class ComboManualName extends AbstractDTO
{
    public int $id;
    /** Default: '' */
    public string $title;
    /** Default: 0 */
    public bool $isReadonly;
    /** Default: '' */
    public string $name;

    /** @var array{
     *       "id": string,
     *       "title": string,
     *       "is_readonly": string,
     *       "name": string
     *   } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->isReadonly = (bool)$this->originalData['is_readonly'];
        $this->name = (string)$this->originalData['name'];
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\ComboManualName::fromRequestGetById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
