<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DTO\Enum\Invoice\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class InvoiceDto extends AbstractDTO
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
    /** @var ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null */
    public ?int $call;
    /** Примеры: '0.0000000000', "240.0000000000" */
    public float $paidAmount;
    /** DB default: '0000-00-00 00:00:00' */
    public DateTime $createDate;
    /** Default: 'none' */
    public PaymentStatus $paymentStatus;
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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->doctorId = ApiInt::fromStringOrNull($originalDataArray['doctor_id'])->positiveIntOrNull;
        $instance->clientId = ApiInt::fromStringOrNull($originalDataArray['client_id'])->positiveInt;
        $instance->petId = ApiInt::fromStringOrNull($originalDataArray['pet_id'])->positiveInt;
        $instance->description = ApiString::fromStringOrNull($originalDataArray['description'])->string;
        $instance->percent = ApiFloat::fromStringOrNull($originalDataArray['percent'])->float;
        $instance->amount = ApiFloat::fromStringOrNull($originalDataArray['amount'])->float;
        $instance->status = Status::from($originalDataArray['status']);
        $instance->invoiceDate = ApiDateTime::fromOnlyDateString($originalDataArray['invoice_date'])->dateTime;
        $instance->oldId = ApiInt::fromStringOrNull($originalDataArray['old_id'])->positiveIntOrNull;
        $instance->night = ApiInt::fromStringOrNull($originalDataArray['night'])->positiveIntOrNull;
        $instance->increase = ApiFloat::fromStringOrNull($originalDataArray['increase'])->float;
        $instance->discount = ApiFloat::fromStringOrNull($originalDataArray['discount'])->float;
        $instance->call = ApiInt::fromStringOrNull($originalDataArray['call'])->positiveIntOrNull;
        $instance->paidAmount = ApiFloat::fromStringOrNull($originalDataArray['paid_amount'])->float;
        $instance->createDate = ApiDateTime::fromOnlyDateString($originalDataArray['create_date'])->dateTime;
        $instance->paymentStatus = PaymentStatus::from($originalDataArray['payment_status']);
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->positiveIntOrNull;
        $instance->creatorId = ApiInt::fromStringOrNull($originalDataArray['creator_id'])->positiveIntOrNull;
        $instance->fiscalSectionId = ApiInt::fromStringOrNull($originalDataArray['fiscal_section_id'])->positiveIntOrNull;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO check
    {
        return [];
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
