<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardPlusPetDto;

final class MedicalCardPlusPet extends AbstractMedicalCard
{
    public static function getDtoClass(): string
    {
        return MedicalCardPlusPetDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, MedicalCardPlusPetDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getPet(): AbstractPet
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getPetOnlyDto(), PetOnly::class);
    }
}
