<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\Good $self */
class Good extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var ?positive-int */
    public ?int $groupId;
    public string $title;
    /** @var ?positive-int */
    public ?int $unitStorageId;
    /** Default: 1 */
    public bool $isWarehouseAccount;
    /** Default: 1 */
    public bool $isActive;
    public string $code;
    /** Default: 0 */
    public bool $isCall;
    /** Default: 1 */
    public bool $isForSale;
    public string $barcode;
    public ?DateTime $createDate;
    public string $description;
    /** Default: '0.0000000000' */
    public float $primeCost;
    /** @var ?positive-int */
    public ?int $categoryId;

    /** @param array{
     *     "id": string,
     *     "group_id": ?string,
     *     "title": string,
     *     "unit_storage_id": ?string,
     *     "is_warehouse_account": string,
     *     "is_active": string,
     *     "code": ?string,
     *     "is_call": string,
     *     "is_for_sale": string,
     *     "barcode": ?string,
     *     "create_date": string,
     *     "description": string,
     *     "prime_cost": string,
     *     "category_id": ?string,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->groupId = IntContainer::fromStringOrNull($this->originalData['group_id'])->positiveIntOrNull;
        $this->title = StringContainer::fromStringOrNull($this->originalData['title'])->string;
        $this->unitStorageId = IntContainer::fromStringOrNull($this->originalData['unit_storage_id'])->positiveIntOrNull;
        $this->isWarehouseAccount = BoolContainer::fromStringOrNull($this->originalData['is_warehouse_account'])->bool;
        $this->isActive = BoolContainer::fromStringOrNull($this->originalData['is_active'])->bool;
        $this->code = StringContainer::fromStringOrNull($this->originalData['code'])->string;
        $this->isCall = BoolContainer::fromStringOrNull($this->originalData['is_call'])->bool;
        $this->isForSale = BoolContainer::fromStringOrNull($this->originalData['is_for_sale'])->bool;
        $this->barcode = StringContainer::fromStringOrNull($this->originalData['barcode'])->string;
        $this->createDate = DateTimeContainer::fromOnlyDateString($this->originalData['create_date'])->dateTimeOrNull;
        $this->description = StringContainer::fromStringOrNull($this->originalData['description'])->string;
        $this->primeCost = FloatContainer::fromStringOrNull($this->originalData['prime_cost'])->float;
        $this->categoryId = IntContainer::fromStringOrNull($this->originalData['category_id'])->positiveIntOrNull;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Good::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
