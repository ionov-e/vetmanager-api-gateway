<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\User;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;
use VetmanagerApiGateway\Hydrator\Enum\DtoPropertyMode;

final class UserPlusPositionAndRoleDto extends UserOnlyDto
{
}
