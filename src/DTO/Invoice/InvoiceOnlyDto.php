<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->doctorId = ApiInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNull();
        $instance->clientId = ApiInt::fromStringOrNull($originalDataArray['client_id'])->getPositiveInt();
        $instance->petId = ApiInt::fromStringOrNull($originalDataArray['pet_id'])->getPositiveInt();
        $instance->description = ApiString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->percent = ApiFloat::fromStringOrNull($originalDataArray['percent'])->getNonZeroFloatOrNull();
        $instance->amount = ApiFloat::fromStringOrNull($originalDataArray['amount'])->getNonZeroFloatOrNull();
        $instance->status = StatusEnum::from($originalDataArray['status']);
        $instance->invoiceDate = ApiDateTime::fromOnlyDateString($originalDataArray['invoice_date'])->getDateTimeOrThrow();
        $instance->oldId = ApiInt::fromStringOrNull($originalDataArray['old_id'])->getPositiveIntOrNull();
        $instance->night = ApiInt::fromStringOrNull($originalDataArray['night'])->getPositiveIntOrNull();
        $instance->increase = ApiFloat::fromStringOrNull($originalDataArray['increase'])->getNonZeroFloatOrNull();
        $instance->discount = ApiFloat::fromStringOrNull($originalDataArray['discount'])->getNonZeroFloatOrNull();
        $instance->call = ApiInt::fromStringOrNull($originalDataArray['call'])->getPositiveIntOrNull();
        $instance->paidAmount = ApiFloat::fromStringOrNull($originalDataArray['paid_amount'])->getNonZeroFloatOrNull();
        $instance->createDate = ApiDateTime::fromOnlyDateString($originalDataArray['create_date'])->getDateTimeOrThrow();
        $instance->paymentStatus = PaymentStatusEnum::from($originalDataArray['payment_status']);
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNull();
        $instance->creatorId = ApiInt::fromStringOrNull($originalDataArray['creator_id'])->getPositiveIntOrNull();
        $instance->fiscalSectionId = ApiInt::fromStringOrNull($originalDataArray['fiscal_section_id'])->getPositiveIntOrNull();
        return $instance;
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            property_exists($this, 'doctorId') ? ['doctor_id' => $this->doctorId] : [],
            property_exists($this, 'clientId') ? ['client_id' => $this->clientId] : [],
            property_exists($this, 'petId') ? ['pet_id' => $this->petId] : [],
            property_exists($this, 'description') ? ['description' => $this->description] : [],
            property_exists($this, 'percent') ? ['percent' => $this->percent] : [],
            property_exists($this, 'amount') ? ['amount' => $this->amount] : [],
            property_exists($this, 'status') ? ['status' => $this->status] : [],
            property_exists($this, 'invoiceDate') ? ['invoice_date' => $this->invoiceDate->format('Y-m-d H:i:s')] : [],
            property_exists($this, 'oldId') ? ['old_id' => $this->oldId] : [],
            property_exists($this, 'night') ? ['night' => $this->night] : [],
            property_exists($this, 'increase') ? ['increase' => $this->increase] : [],
            property_exists($this, 'discount') ? ['discount' => $this->discount] : [],
            property_exists($this, 'call') ? ['call' => $this->call] : [],
            property_exists($this, 'paidAmount') ? ['paid_amount' => $this->paidAmount] : [],
            property_exists($this, 'createDate') ? ['create_date' => $this->createDate->format('Y-m-d H:i:s')] : [],
            property_exists($this, 'paymentStatus') ? ['payment_status' => $this->paymentStatus] : [],
            property_exists($this, 'clinicId') ? ['clinic_id' => $this->clinicId] : [],
            property_exists($this, 'creatorId') ? ['creator_id' => $this->creatorId] : [],
            property_exists($this, 'fiscalSectionId') ? ['fiscal_section_id' => $this->fiscalSectionId] : [],
        );
    }
}
