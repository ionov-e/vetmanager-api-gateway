<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class MedicalCardOnly extends AbstractMedicalCard
{
    public static function getDtoClass(): string
    {
        return MedicalCardOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPet(): AbstractPet
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId());
    }
}
