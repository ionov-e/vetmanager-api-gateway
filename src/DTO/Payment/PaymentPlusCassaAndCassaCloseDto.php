<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Payment;

use VetmanagerApiGateway\DTO\Cassa\CassaOnlyDto;
use VetmanagerApiGateway\DTO\CassaClose\CassaCloseOnlyDto;

class PaymentPlusCassaAndCassaCloseDto extends PaymentOnlyDto
{
    /**
     * @param int|string|null $id
     * @param string|null $amount
     * @param string|null $status
     * @param int|string|null $cassa_id
     * @param int|string|null $cassaclose_id
     * @param string|null $create_date
     * @param int|string|null $payed_user
     * @param string|null $description
     * @param string|null $payment_type
     * @param int|string|null $invoice_id
     * @param int|string|null $parent_id
     * @param CassaOnlyDto $cassa
     * @param CassaCloseOnlyDto|null $cassaclose
     */
    public function __construct(
        public int|string|null    $id,
        public ?string            $amount,
        public ?string            $status,
        public int|string|null    $cassa_id,
        public int|string|null    $cassaclose_id,
        public ?string            $create_date,
        public int|string|null    $payed_user,
        public ?string            $description,
        public ?string            $payment_type,
        public int|string|null    $invoice_id,
        public int|string|null    $parent_id,
        public CassaOnlyDto $cassa,
        public ?CassaCloseOnlyDto $cassaclose
    )
    {
        parent::__construct(
            $id,
            $amount,
            $status,
            $cassa_id,
            $cassaclose_id,
            $create_date,
            $payed_user,
            $description,
            $payment_type,
            $invoice_id,
            $parent_id,
        );
    }

    public function getCassa(): CassaOnlyDto
    {
        return $this->cassa;
    }

    public function getCassaClose(): ?CassaCloseOnlyDto
    {
        return $this->cassaclose;
    }
}
