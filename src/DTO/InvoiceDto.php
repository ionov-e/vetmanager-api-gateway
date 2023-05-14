<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DTO\Enum\Invoice\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class InvoiceDto extends AbstractDTO
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
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->doctorId = IntContainer::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $this->clientId = IntContainer::fromStringOrNull($originalData['client_id'])->positiveInt;
        $this->petId = IntContainer::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $this->description = StringContainer::fromStringOrNull($originalData['description'])->string;
        $this->percent = FloatContainer::fromStringOrNull($originalData['percent'])->float;
        $this->amount = FloatContainer::fromStringOrNull($originalData['amount'])->float;
        $this->status = Status::from($originalData['status']);
        $this->invoiceDate = DateTimeContainer::fromOnlyDateString($originalData['invoice_date'])->dateTime;
        $this->oldId = IntContainer::fromStringOrNull($originalData['old_id'])->positiveIntOrNull;
        $this->night = IntContainer::fromStringOrNull($originalData['night'])->positiveIntOrNull;
        $this->increase = FloatContainer::fromStringOrNull($originalData['increase'])->float;
        $this->discount = FloatContainer::fromStringOrNull($originalData['discount'])->float;
        $this->call = IntContainer::fromStringOrNull($originalData['call'])->positiveIntOrNull;
        $this->paidAmount = FloatContainer::fromStringOrNull($originalData['paid_amount'])->float;
        $this->createDate = DateTimeContainer::fromOnlyDateString($originalData['create_date'])->dateTime;
        $this->paymentStatus = PaymentStatus::from($originalData['payment_status']);
        $this->clinicId = IntContainer::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $this->creatorId = IntContainer::fromStringOrNull($originalData['creator_id'])->positiveIntOrNull;
        $this->fiscalSectionId = IntContainer::fromStringOrNull($originalData['fiscal_section_id'])->positiveIntOrNull;
    }
}
