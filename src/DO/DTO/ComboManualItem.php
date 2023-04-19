<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * Обращается в таблицу combo_manual_items
 *
 * @property-read DAO\ComboManualItem $self
 */
class ComboManualItem extends AbstractDTO
{
    /** @var positive-int ID записи цвета в таблице combo_manual_items */
    public int $id;
    /** @var positive-int Тип "подтаблицы". Например, будет всегда одинаковый id для "подтаблицы" с цветами.
     * В БД Default: 0, но ни в одной таблице такого значения не нашел */
    public int $comboManualId;
    /** Default: '' */
    public string $title;
    /** Default: '' */
    public string $value;
    /** Default: '' */
    public string $dopParam1;
    /** Default: '' */
    public string $dopParam2;
    /** Default: '' */
    public string $dopParam3;
    /** Default: 1 */
    public bool $isActive;

    /** @param array{
     *       "id": string,
     *       "combo_manual_id": string,
     *       "title": string,
     *       "value": string,
     *       "dop_param1": string,
     *       "dop_param2": string,
     *       "dop_param3": string,
     *       "is_active": string,
     *       "comboManualName"?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->comboManualId = IntContainer::fromStringOrNull($this->originalData['combo_manual_id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($this->originalData['title'])->string;
        $this->value = StringContainer::fromStringOrNull($this->originalData['value'])->string;
        $this->dopParam1 = StringContainer::fromStringOrNull($this->originalData['dop_param1'])->string;
        $this->dopParam2 = StringContainer::fromStringOrNull($this->originalData['dop_param2'])->string;
        $this->dopParam3 = StringContainer::fromStringOrNull($this->originalData['dop_param3'])->string;
        $this->isActive = BoolContainer::fromStringOrNull($this->originalData['is_active'])->bool;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\ComboManualItem::getById($this->apiGateway, $this->id),
            default => $this->$name
        };
    }
}
