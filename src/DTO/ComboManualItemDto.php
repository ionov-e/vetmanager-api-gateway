<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** Обращается в таблицу combo_manual_items
 * @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая
 */
final class ComboManualItemDto extends AbstractDTO
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
     *       id: string,
     *       combo_manual_id: string,
     *       title: string,
     *       value: string,
     *       dop_param1: string,
     *       dop_param2: string,
     *       dop_param3: string,
     *       is_active: string,
     *       comboManualName?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->comboManualId = ApiInt::fromStringOrNull($originalData['combo_manual_id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->string;
        $instance->value = ApiString::fromStringOrNull($originalData['value'])->string;
        $instance->dopParam1 = ApiString::fromStringOrNull($originalData['dop_param1'])->string;
        $instance->dopParam2 = ApiString::fromStringOrNull($originalData['dop_param2'])->string;
        $instance->dopParam3 = ApiString::fromStringOrNull($originalData['dop_param3'])->string;
        $instance->isActive = ApiBool::fromStringOrNull($originalData['is_active'])->bool;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['combo_manual_id', 'title', 'value'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->comboManualId) ? ['combo_manual_id' => $this->comboManualId] : [],
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->value) ? ['value' => $this->value] : [],
            isset($this->dopParam1) ? ['dop_param1' => $this->dopParam1] : [],
            isset($this->dopParam2) ? ['dop_param2' => $this->dopParam2] : [],
            isset($this->dopParam3) ? ['dop_param3' => $this->dopParam3] : [],
            isset($this->isActive) ? ['is_active' => (int)$this->isActive] : [],
        );
    }
}
