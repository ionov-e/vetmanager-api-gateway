<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DTO\Enum\Invoice\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Service\DateTimeService;

/** @property-read DAO\Invoice $self */
class Invoice extends AbstractDTO
{
    public int $id;
    public ?int $doctorId;
    public int $clientId;
    public int $petId;
    public string $description;
    public ?float $percent;
    public ?float $amount;
    public Status $status;
    public DateTime $invoiceDate;
    public ?int $oldId;
    /** Default: '0' */
    public int $night;
    public ?float $increase;
    public ?float $discount;
    /** Default: '0' */
    public int $call;
    /** Default: '0.0000000000' */
    public float $paidAmount;
    /** Default: '0000-00-00 00:00:00' */
    public DateTime $createDate;
    /** Default: 'none' */
    public PaymentStatus $paymentStatus;
    /** Default: '0' */
    public int $clinicId;
    public ?int $creatorId;
    /** Default: '0' */
    public int $fiscalSectionId;

    /** @var array{
     *     "id": string,
     *     "doctor_id": ?string,
     *     "client_id": string,
     *     "pet_id": string,
     *     "description": string,
     *     "percent": ?string,
     *     "amount": ?string,
     *     "status": string,
     *     "invoice_date": string,
     *     "old_id": ?string,
     *     "night": string,
     *     "increase": ?string,
     *     "discount": ?string,
     *     "call": string,
     *     "paid_amount": string,
     *     "create_date": string,
     *     "payment_status": string,
     *     "clinic_id": string,
     *     "creator_id": ?string,
     *     "fiscal_section_id": string,
     *  }
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->doctorId = $this->originalData['doctor_id'] ? (int)$this->originalData['doctor_id'] : null;
        $this->clientId = (int)$this->originalData['client_id'];
        $this->petId = (int)$this->originalData['pet_id'];
        $this->description = (string)$this->originalData['description'];
        $this->percent = !is_null($this->originalData['percent']) ? (float)$this->originalData['percent'] : null;
        $this->amount = !is_null($this->originalData['amount']) ? (float)$this->originalData['amount'] : null;
        $this->status = Status::from($this->originalData['status']);
        $this->invoiceDate = (DateTimeService::fromOnlyDateString($this->originalData['invoice_date']))->dateTime;
        $this->oldId = $this->originalData['old_id'] ? (int)$this->originalData['old_id'] : null;
        $this->night = (int)$this->originalData['night'];
        $this->increase = !is_null($this->originalData['increase']) ? (float)$this->originalData['increase'] : null;
        $this->discount = !is_null($this->originalData['discount']) ? (float)$this->originalData['discount'] : null;
        $this->call = (int)$this->originalData['call'];
        $this->paidAmount = (float)$this->originalData['paid_amount'];
        $this->createDate = (DateTimeService::fromOnlyDateString($this->originalData['create_date']))->dateTime;
        $this->paymentStatus = PaymentStatus::from($this->originalData['payment_status']);
        $this->clinicId = (int)$this->originalData['clinic_id'];
        $this->creatorId = $this->originalData['creator_id'] ? (int)$this->originalData['creator_id'] : null;
        $this->fiscalSectionId = (int)$this->originalData['fiscal_section_id'];
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Invoice::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
