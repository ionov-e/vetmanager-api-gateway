<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Payment;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Cassa\Cassa;
use VetmanagerApiGateway\ActiveRecord\CassaClose\AbstractCassaClose;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Payment\PaymentPlusCassaAndCassaCloseDto;

class PaymentPlusCassaAndCassaClose extends AbstractPayment
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, PaymentPlusCassaAndCassaCloseDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /**
     * @inheritDoc
     */
    public static function getDtoClass(): string
    {
        return PaymentPlusCassaAndCassaCloseDto::class;
    }

    public function getCassa(): Cassa
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getCassa(), ActiveRecord\Cassa\Cassa::class);
    }

    public function getCassaClose(): ?AbstractCassaClose
    {
        $dto = $this->modelDTO->getCassaClose();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, ActiveRecord\CassaClose\CassaCloseOnly::class) : null;
    }
}