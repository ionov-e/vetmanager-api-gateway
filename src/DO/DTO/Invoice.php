<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DO\Enum\Invoice\Status;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\Invoice $self */
class Invoice extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var ?positive-int Ни в одной базе не нашел, чтобы было 0 или null */
    public ?int $doctorId;
    /** @var positive-int Ни в одной базе не нашел, чтобы было 0 или null */
    public int $clientId;
    /** @var positive-int Ни в одной базе не нашел, чтобы было 0 или null */
    public int $petId;
    public string $description;
    /** Округляется до целых. Примеры: "0.0000000000", "-3.0000000000" */
    public float $percent;
    /** Примеры: "0.0000000000", "150.0000000000" */
    public float $amount;
    public Status $status;
    public DateTime $invoiceDate;
    /** @var ?positive-int */
    public ?int $oldId;
    /** @var ?positive-int */
    public ?int $night;
    /** Примеры: "0.0000000000" */
    public float $increase;
    /** Примеры: "0.0000000000", "3.0000000000" */
    public float $discount;
    /** @var ?positive-int Default: '0' - переводим в null. В БД не видел 0/null */
    public ?int $call;
    /** Примеры: '0.0000000000', "240.0000000000" */
    public float $paidAmount;
    /** Default: '0000-00-00 00:00:00' */
    public DateTime $createDate;
    /** Default: 'none' */
    public PaymentStatus $paymentStatus;
    /** @var ?positive-int Default: '0' - переводим в null. В БД не видел 0/null */
    public ?int $clinicId;
    /** @var ?positive-int */
    public ?int $creatorId;
    /** @var ?positive-int Default: '0' - переводим в null. Редко вижу не 0 */
    public ?int $fiscalSectionId;

    /** @param array{
     *     "id": string,
     *     "doctor_id": ?numeric-string,
     *     "client_id": numeric-string,
     *     "pet_id": numeric-string,
     *     "description": string,
     *     "percent": ?string,
     *     "amount": ?string,
     *     "status": string,
     *     "invoice_date": string,
     *     "old_id": ?numeric-string,
     *     "night": numeric-string,
     *     "increase": ?string,
     *     "discount": ?string,
     *     "call": numeric-string,
     *     "paid_amount": string,
     *     "create_date": string,
     *     "payment_status": string,
     *     "clinic_id": numeric-string,
     *     "creator_id": ?numeric-string,
     *     "fiscal_section_id": numeric-string,
     *     "client"?: array,
     *     "pet"?: array,
     *     "doctor"?: array,
     *     "invoiceDocuments"?: array
     *  } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->doctorId = IntContainer::fromStringOrNull($this->originalData['doctor_id'])->positiveIntOrNull;
        $this->clientId = IntContainer::fromStringOrNull($this->originalData['client_id'])->positiveInt;
        $this->petId = IntContainer::fromStringOrNull($this->originalData['pet_id'])->positiveInt;
        $this->description = StringContainer::fromStringOrNull($this->originalData['description'])->string;
        $this->percent = FloatContainer::fromStringOrNull($this->originalData['percent'])->float;
        $this->amount = FloatContainer::fromStringOrNull($this->originalData['amount'])->float;
        $this->status = Status::from($this->originalData['status']);
        $this->invoiceDate = DateTimeContainer::fromOnlyDateString($this->originalData['invoice_date'])->dateTime;
        $this->oldId = IntContainer::fromStringOrNull($this->originalData['old_id'])->positiveIntOrNull;
        $this->night = IntContainer::fromStringOrNull($this->originalData['night'])->positiveIntOrNull;
        $this->increase = FloatContainer::fromStringOrNull($this->originalData['increase'])->float;
        $this->discount = FloatContainer::fromStringOrNull($this->originalData['discount'])->float;
        $this->call = IntContainer::fromStringOrNull($this->originalData['call'])->positiveIntOrNull;
        $this->paidAmount = FloatContainer::fromStringOrNull($this->originalData['paid_amount'])->float;
        $this->createDate = DateTimeContainer::fromOnlyDateString($this->originalData['create_date'])->dateTime;
        $this->paymentStatus = PaymentStatus::from($this->originalData['payment_status']);
        $this->clinicId = IntContainer::fromStringOrNull($this->originalData['clinic_id'])->positiveIntOrNull;
        $this->creatorId = IntContainer::fromStringOrNull($this->originalData['creator_id'])->positiveIntOrNull;
        $this->fiscalSectionId = IntContainer::fromStringOrNull($this->originalData['fiscal_section_id'])->positiveIntOrNull;
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
