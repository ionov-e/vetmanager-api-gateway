<?php


use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestUrlDomainException;

class AbstractPaymentTest extends TestCase
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
    public function testActiveRecord(): void
    {
        $activeRecords = $this->apiGateway->getPayment()->getAll();
        $activeRecord = $activeRecords[0];
        $this->assertIsString($activeRecord->getDescription());
        $this->assertIsInt($activeRecord->getCassaId());
        $this->assertInstanceOf(VetmanagerApiGateway\ActiveRecord\Cassa\Cassa::class, $activeRecord->getCassa());
    }

    /**
     * @throws VetmanagerApiGatewayRequestException
     * @throws VetmanagerApiGatewayException
     */
    public function testGetByInvoiceId(): void
    {
        $randomInvoiceId = 1;
        $activeRecords = $this->apiGateway->getPayment()->getByInvoiceId($randomInvoiceId);

        if (empty($activeRecords)) {
            $this->markTestSkipped('Заглушка: может случиться, что на сервере нет у Счета Оплат. Но ниже строки работали');
        }

        $activeRecord = $activeRecords[0];
        $this->assertIsString($activeRecord->getDescription());
        $this->assertIsInt($activeRecord->getCassaId());
        $this->assertInstanceOf(VetmanagerApiGateway\ActiveRecord\Cassa\Cassa::class, $activeRecord->getCassa());
    }
}
