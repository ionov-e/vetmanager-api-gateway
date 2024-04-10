<?php

namespace VetmanagerApiGateway\Integration;

use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestUrlDomainException;

class AbstractComboManualItemTest extends TestCase
{
    private ApiGateway $apiGateway;

    /** @throws VetmanagerApiGatewayRequestUrlDomainException */
    protected function setUp(): void
    {
        $this->apiGateway = ApiGateway::fromSubdomainAndApiKey(
            getenv('TEST_SUBDOMAIN_1'),
            getenv('TEST_API_KEY_1'),
            filter_var(getenv('IS_PROD_SUBDOMAIN'), FILTER_VALIDATE_BOOL)
        );
    }

    /**
     * @throws VetmanagerApiGatewayRequestException
     * @throws VetmanagerApiGatewayException
     */
    public function testGetTitle(): void
    {
        $randomAdmissionTypeId = 1;
        $comboManualItemFacade = $this->apiGateway->getComboManualItem();
        $comboManualItem = $comboManualItemFacade->getByAdmissionTypeId($randomAdmissionTypeId);
        $admissionTypeTitle = $comboManualItem->getTitle();
        $this->assertIsString($admissionTypeTitle);
    }
}
