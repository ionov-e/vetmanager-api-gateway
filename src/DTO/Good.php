<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use Exception;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\Good $self */
class Good extends AbstractDTO
{
    public int $id;
    public ?int $groupId;
    public string $title;
    public ?int $unitStorageId;
    /** Default: 1 */
    public bool $isWarehouseAccount;
    /** Default: 1 */
    public bool $isActive;
    public ?string $code;
    public ?int $categoryId;
    /** Default: 0 */
    public bool $isCall;
    /** Default: 1 */
    public bool $isForSale;
    public ?string $barcode;
    public DateTime $createDate;
    public string $description;
    /** Default: '0.0000000000' */
    public float $primeCost;
    /** Предзагружен. Нового АПИ запроса не будет */

    /** @var array{
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
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->groupId = $this->originalData['group_id'] ? (int)$this->originalData['group_id'] : null;
        $this->title = (string)$this->originalData['title'];
        $this->unitStorageId = $this->originalData['unit_storage_id'] ? (int)$this->originalData['unit_storage_id'] : null;
        $this->isWarehouseAccount = (bool)$this->originalData['is_warehouse_account'];
        $this->isActive = (bool)$this->originalData['is_active'];
        $this->code = $this->originalData['code'] ? (string)$this->originalData['code'] : null;
        $this->categoryId = $this->originalData['category_id'] ? (int)$this->originalData['category_id'] : null;
        $this->isCall = (bool)$this->originalData['is_call'];
        $this->isForSale = (bool)$this->originalData['is_for_sale'];
        $this->barcode = $this->originalData['barcode'] ? (string)$this->originalData['barcode'] : null;
        $this->description = (string)$this->originalData['description'];
        $this->primeCost = (float)$this->originalData['prime_cost'];

        try {
            $this->createDate = new DateTime($this->originalData['create_date']);
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayException($e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Good::fromRequestGetById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
