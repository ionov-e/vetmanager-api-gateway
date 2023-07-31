<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class InvoiceOnlyDto extends AbstractDTO
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
    public StatusEnum $status;
    public DateTime $invoiceDate;
    /** @var ?positive-int */
    public ?int $oldId;
    /** @var ?positive-int */
    public ?int $night;
    /** Примеры: "0.0000000000" */
    public float $increase;
    /** Примеры: "0.0000000000", "3.0000000000" */
    public float $discount;
    /** @var ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null */
    public ?int $call;
    /** Примеры: '0.0000000000', "240.0000000000" */
    public float $paidAmount;
    /** DB default: '0000-00-00 00:00:00' */
    public DateTime $createDate;
    /** Default: 'none' */
    public PaymentStatusEnum $paymentStatus;
    /** @var ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null */
    public ?int $clinicId;
    /** @var ?positive-int */
    public ?int $creatorId;
    /** @var ?positive-int Default: '0' - переводим в null. Редко вижу не 0 */
    public ?int $fiscalSectionId;

    /** @param array{
     *     id: string,
     *     doctor_id: ?numeric-string,
     *     client_id: numeric-string,
     *     pet_id: numeric-string,
     *     description: string,
     *     percent: ?string,
     *     amount: ?string,
     *     status: string,
     *     invoice_date: string,
     *     old_id: ?numeric-string,
     *     night: numeric-string,
     *     increase: ?string,
     *     discount: ?string,
     *     call: numeric-string,
     *     paid_amount: string,
     *     create_date: string,
     *     payment_status: string,
     *     clinic_id: numeric-string,
     *     creator_id: ?numeric-string,
     *     fiscal_section_id: numeric-string,
     *     client?: array,
     *     pet?: array,
     *     doctor?: array,
     *     invoiceDocuments?: array
     *  } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->doctorId = ToInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNull();
        $instance->clientId = ToInt::fromStringOrNull($originalDataArray['client_id'])->getPositiveInt();
        $instance->petId = ToInt::fromStringOrNull($originalDataArray['pet_id'])->getPositiveInt();
        $instance->description = ToString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->percent = ToFloat::fromStringOrNull($originalDataArray['percent'])->getNonZeroFloatOrNull();
        $instance->amount = ToFloat::fromStringOrNull($originalDataArray['amount'])->getNonZeroFloatOrNull();
        $instance->status = StatusEnum::from($originalDataArray['status']);
        $instance->invoiceDate = ToDateTime::fromOnlyDateString($originalDataArray['invoice_date'])->getDateTimeOrThrow();
        $instance->oldId = ToInt::fromStringOrNull($originalDataArray['old_id'])->getPositiveIntOrNull();
        $instance->night = ToInt::fromStringOrNull($originalDataArray['night'])->getPositiveIntOrNull();
        $instance->increase = ToFloat::fromStringOrNull($originalDataArray['increase'])->getNonZeroFloatOrNull();
        $instance->discount = ToFloat::fromStringOrNull($originalDataArray['discount'])->getNonZeroFloatOrNull();
        $instance->call = ToInt::fromStringOrNull($originalDataArray['call'])->getPositiveIntOrNull();
        $instance->paidAmount = ToFloat::fromStringOrNull($originalDataArray['paid_amount'])->getNonZeroFloatOrNull();
        $instance->createDate = ToDateTime::fromOnlyDateString($originalDataArray['create_date'])->getDateTimeOrThrow();
        $instance->paymentStatus = PaymentStatusEnum::from($originalDataArray['payment_status']);
        $instance->clinicId = ToInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNull();
        $instance->creatorId = ToInt::fromStringOrNull($originalDataArray['creator_id'])->getPositiveIntOrNull();
        $instance->fiscalSectionId = ToInt::fromStringOrNull($originalDataArray['fiscal_section_id'])->getPositiveIntOrNull();
        return $instance;
    }
}
