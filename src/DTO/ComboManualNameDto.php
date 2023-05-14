<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class ComboManualNameDto extends AbstractDTO
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
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->isReadonly = BoolContainer::fromStringOrNull($originalData['is_readonly'])->bool;
        $this->name = StringContainer::fromStringOrNull($originalData['name'])->string;
    }
}
