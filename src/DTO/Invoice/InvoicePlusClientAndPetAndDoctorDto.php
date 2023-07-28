<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class InvoicePlusClientAndPetAndDoctorDto extends InvoiceOnlyDto
{
}
