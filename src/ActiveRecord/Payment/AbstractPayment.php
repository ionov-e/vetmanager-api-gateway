<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Payment;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoices;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\MedicalCardPlusPet;
use VetmanagerApiGateway\ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination;
use VetmanagerApiGateway\ActiveRecord\MedicalCardByClient\MedicalCardByClient;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Payment\PaymentOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\DTO\Pet\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

/** TODO */
abstract class AbstractPayment extends AbstractActiveRecord implements PetOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'payment';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PaymentOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Payment($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Payment($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Payment($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */ #TODO
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

}
