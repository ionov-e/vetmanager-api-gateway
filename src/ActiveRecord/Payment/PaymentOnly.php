<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Payment;

use VetmanagerApiGateway\ActiveRecord\Cassa\Cassa;
use VetmanagerApiGateway\ActiveRecord\CassaClose\AbstractCassaClose;
use VetmanagerApiGateway\DTO\Payment\PaymentOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

class PaymentOnly extends AbstractPayment
{
    /**
     * @inheritDoc
     */
    public static function getDtoClass(): string
    {
        return PaymentOnlyDto::class;
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function getCassa(): Cassa
    {
        return (new Facade\Cassa($this->activeRecordFactory))->getById($this->getCassaId());
    }

    /**
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function getCassaClose(): ?AbstractCassaClose
    {
        $cassaCloseId = $this->getCassaCloseId();
        return $cassaCloseId
            ? (new Facade\CassaClose($this->activeRecordFactory))->getById($cassaCloseId)
            : null;
    }
}