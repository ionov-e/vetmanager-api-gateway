<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Breed extends AbstractFacade
{
    /** @inheritDoc */
    static public function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Breed::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Breed
    {
        return $this->protectedGetById(self::getDefaultActiveRecord(), $id);
    }






    //    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::OnlyBasicDto;
//    }
}