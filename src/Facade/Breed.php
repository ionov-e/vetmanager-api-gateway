<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Breed extends AbstractFacade implements AllRequestsInterface
{
    /** @inheritDoc */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Breed\Breed::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Breed\Breed
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }






//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::OnlyBasicDto;
//    }
}