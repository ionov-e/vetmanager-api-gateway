<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class InvoiceDocumentPlusGoodSaleParamWithUnitAndDocumentAndGoodDto extends InvoiceOnlyDto
{
}
