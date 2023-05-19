<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\DTO\Enum\Invoice\PaymentStatus;
use VetmanagerApiGateway\DTO\Enum\Invoice\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
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
     *  } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->doctorId = ApiInt::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $instance->clientId = ApiInt::fromStringOrNull($originalData['client_id'])->positiveInt;
        $instance->petId = ApiInt::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $instance->description = ApiString::fromStringOrNull($originalData['description'])->string;
        $instance->percent = ApiFloat::fromStringOrNull($originalData['percent'])->float;
        $instance->amount = ApiFloat::fromStringOrNull($originalData['amount'])->float;
        $instance->status = Status::from($originalData['status']);
        $instance->invoiceDate = ApiDateTime::fromOnlyDateString($originalData['invoice_date'])->dateTime;
        $instance->oldId = ApiInt::fromStringOrNull($originalData['old_id'])->positiveIntOrNull;
        $instance->night = ApiInt::fromStringOrNull($originalData['night'])->positiveIntOrNull;
        $instance->increase = ApiFloat::fromStringOrNull($originalData['increase'])->float;
        $instance->discount = ApiFloat::fromStringOrNull($originalData['discount'])->float;
        $instance->call = ApiInt::fromStringOrNull($originalData['call'])->positiveIntOrNull;
        $instance->paidAmount = ApiFloat::fromStringOrNull($originalData['paid_amount'])->float;
        $instance->createDate = ApiDateTime::fromOnlyDateString($originalData['create_date'])->dateTime;
        $instance->paymentStatus = PaymentStatus::from($originalData['payment_status']);
        $instance->clinicId = ApiInt::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $instance->creatorId = ApiInt::fromStringOrNull($originalData['creator_id'])->positiveIntOrNull;
        $instance->fiscalSectionId = ApiInt::fromStringOrNull($originalData['fiscal_section_id'])->positiveIntOrNull;
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
            isset($this->doctorId) ? ['doctor_id' => $this->doctorId] : [],
            isset($this->clientId) ? ['client_id' => $this->clientId] : [],
            isset($this->petId) ? ['pet_id' => $this->petId] : [],
            isset($this->description) ? ['description' => $this->description] : [],
            isset($this->percent) ? ['percent' => $this->percent] : [],
            isset($this->amount) ? ['amount' => $this->amount] : [],
            isset($this->status) ? ['status' => $this->status] : [],
            isset($this->invoiceDate) ? ['invoice_date' => $this->invoiceDate->format('Y-m-d H:i:s')] : [],
            isset($this->oldId) ? ['old_id' => $this->oldId] : [],
            isset($this->night) ? ['night' => $this->night] : [],
            isset($this->increase) ? ['increase' => $this->increase] : [],
            isset($this->discount) ? ['discount' => $this->discount] : [],
            isset($this->call) ? ['call' => $this->call] : [],
            isset($this->paidAmount) ? ['paid_amount' => $this->paidAmount] : [],
            isset($this->createDate) ? ['create_date' => $this->createDate->format('Y-m-d H:i:s')] : [],
            isset($this->paymentStatus) ? ['payment_status' => $this->paymentStatus] : [],
            isset($this->clinicId) ? ['clinic_id' => $this->clinicId] : [],
            isset($this->creatorId) ? ['creator_id' => $this->creatorId] : [],
            isset($this->fiscalSectionId) ? ['fiscal_section_id' => $this->fiscalSectionId] : [],
        );
    }
}
