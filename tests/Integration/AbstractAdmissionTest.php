<?php

use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestUrlDomainException;

class AbstractAdmissionTest extends TestCase
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
    public function testGetTypeTitle(): void
    {
        $admissions = $this->apiGateway->getAdmission()->getAll();

        if (empty($admissions)) {
            $this->markTestSkipped('Заглушка: может случиться, что нет приемов на сервере');
        }

        $randomArrayKey = array_rand($admissions);
        $admission = $admissions[$randomArrayKey];
        $admissionTypeTitle = $admission->getTypeTitle();

        if (is_null($admission->getTypeId())) {
            $this->assertNull('string');
        } else {
            $this->assertIsString(null);
        }
    }
}
