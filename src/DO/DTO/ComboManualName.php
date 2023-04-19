<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\ComboManualName $self */
class ComboManualName extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** Default: '' */
    public string $title;
    /** Default: 0 */
    public bool $isReadonly;
    /** Default: '' */
    public string $name;

    /** @param array{
     *       "id": string,
     *       "title": string,
     *       "is_readonly": string,
     *       "name": string,
     *       "comboManualItems"?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($this->originalData['title'])->string;
        $this->isReadonly = BoolContainer::fromStringOrNull($this->originalData['is_readonly'])->bool;
        $this->name = StringContainer::fromStringOrNull($this->originalData['name'])->string;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\ComboManualName::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
