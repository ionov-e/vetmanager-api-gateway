<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\ComboManualItem $self
 */
class ComboManualItem extends AbstractDTO
{
    /** Возвращает ID записи цвета в таблице combo_manual_items */
    public int $id;
    /** Default: 0 - Тип "подтаблицы". Например, будет всегда одинаковый id для "подтаблицы" с цветами */
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

    /** @var array{
     *       "id": string,
     *       "combo_manual_id": string,
     *       "title": string,
     *       "value": string,
     *       "dop_param1": string,
     *       "dop_param2": string,
     *       "dop_param3": string,
     *       "is_active": string
     *   } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->comboManualId = (int)$this->originalData['combo_manual_id'];
        $this->title = (string)$this->originalData['title'];
        $this->value = (string)$this->originalData['value'];
        $this->dopParam1 = (string)$this->originalData['dop_param1'];
        $this->dopParam2 = (string)$this->originalData['dop_param2'];
        $this->dopParam3 = (string)$this->originalData['dop_param3'];
        $this->isActive = (bool)$this->originalData['is_active'];
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
