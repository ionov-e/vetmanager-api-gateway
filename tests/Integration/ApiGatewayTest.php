<?php

namespace VetmanagerApiGateway\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Client\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(ApiGateway::class)]
class ApiGatewayTest extends TestCase
{
    /** @throws VetmanagerApiGatewayRequestException */
    public function testFromDomainAndApiKey()
    {
        $apiGateway = ApiGateway::fromSubdomainAndApiKey('three', 'xxx', false);
        $this->assertInstanceOf(ApiGateway::class, $apiGateway);
        return $apiGateway;
    }

    #[Depends('testFromDomainAndApiKey')]
    /** @throws VetmanagerApiGatewayException */
    public function testGetClient(ApiGateway $apiGateway)
    {
        $clients = $apiGateway->getClient()->getAll();
        $this->assertContainsOnlyInstancesOf(ClientPlusTypeAndCity::class, $clients);
        return $clients;
    }

    #[Depends('testGetClient')]
    /** @throws VetmanagerApiGatewayResponseException
     * @var ClientPlusTypeAndCity[] $clients
     */
    public function testGetClientId(array $clients)
    {
        $client = $clients[0];
        $clientId = $client->getId();
        $this->assertIsInt($clientId);
        return $client;
    }

    #[Depends('testGetClientId')]
    public function testGetClientStatus(ClientPlusTypeAndCity $client)
    {
        $this->assertInstanceOf(StatusEnum::class, $client->getStatusAsEnum());
    }

    #[Depends('testFromDomainAndApiKey')]
    /** @throws VetmanagerApiGatewayException */
    public function testCreateEmptyCity(ApiGateway $apiGateway)
    {
        $newEmptyCity = $apiGateway->getCity()->getNewEmpty();
        $this->assertInstanceOf(ActiveRecord\City\City::class, $newEmptyCity);
        $this->assertEmpty($newEmptyCity->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => null, "title" => null, "type_id" => null], $newEmptyCity->getAsArray());
        return $newEmptyCity;
    }

    #[Depends('testCreateEmptyCity')]
    /** @throws VetmanagerApiGatewayException */
    public function testCitySetters(ActiveRecord\City\City $newEmptyCity)
    {
        $cityWithSetValues = $newEmptyCity->setTitle('Test')->setTypeId(1);
        $this->assertEquals(["title" => "Test", "type_id" => "1"], $cityWithSetValues->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => null, "title" => "Test", "type_id" => "1"], $cityWithSetValues->getAsArray());
        return $cityWithSetValues;
    }

    #[Depends('testCitySetters')]
    /** @throws VetmanagerApiGatewayException */
    public function testCityPost(ActiveRecord\City\City $cityWithSetValues)
    {
        $createdCity = $cityWithSetValues->create();
        $this->assertEmpty($createdCity->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals("Test", $createdCity->getTitle());
        $this->assertEquals(1, $createdCity->getTypeId());
        $this->assertIsInt($createdCity->getId());
        return $createdCity;
    }
}
