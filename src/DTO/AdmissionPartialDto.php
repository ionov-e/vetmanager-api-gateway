<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\User;
use VetmanagerApiGateway\DTO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateInterval;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class AdmissionPartialDto extends AdmissionDto
{
}
