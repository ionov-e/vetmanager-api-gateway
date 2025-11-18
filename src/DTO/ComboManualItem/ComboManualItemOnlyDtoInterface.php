<?php

namespace VetmanagerApiGateway\DTO\ComboManualItem;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** Обращается в таблицу combo_manual_items */
interface ComboManualItemOnlyDtoInterface
{
    /** @return positive-int ID записи цвета в таблице combo_manual_items
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return positive-int Тип "подтаблицы". Например, будет всегда одинаковый id для "подтаблицы" с цветами.
     * В БД Default: 0, но ни в одной таблице такого значения не нашел
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getComboManualId(): int;

    /** Default: '' */
    public function getTitle(): string;

    /** Default: '' */
    public function getValue(): string;

    /** Default: '' */
    public function getDopParam1(): string;

    /** Default: '' */
    public function getDopParam2(): string;

    /** Default: '' */
    public function getDopParam3(): string;

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsActive(): bool;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setComboManualId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setValue(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDopParam1(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDopParam2(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDopParam3(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsActive(bool $value): static;
}
