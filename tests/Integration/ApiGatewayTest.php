<?php

namespace VetmanagerApiGateway\Integration;

use Dotenv\Dotenv;
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
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();
        $apiGateway = ApiGateway::fromSubdomainAndApiKey($_ENV['TEST_SUBDOMAIN_1'], $_ENV['TEST_API_KEY_1'], false);
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
        $randomCityTitle = "Test" . rand(1, PHP_INT_MAX);
        $cityWithSetValues = $newEmptyCity->setTitle($randomCityTitle)->setTypeId(1);
        $this->assertEquals(["title" => $randomCityTitle, "type_id" => "1"], $cityWithSetValues->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => null, "title" => $randomCityTitle, "type_id" => "1"], $cityWithSetValues->getAsArray());
        return $cityWithSetValues;
    }

    #[Depends('testCitySetters')]
    /** @throws VetmanagerApiGatewayException */
    public function testCityCreation(ActiveRecord\City\City $cityWithSetValues)
    {
        $createdCity = $cityWithSetValues->create();
        $this->assertEmpty($createdCity->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals($cityWithSetValues->getTitle(), $createdCity->getTitle());
        $this->assertEquals(1, $createdCity->getTypeId());
        $this->assertIsInt($createdCity->getId());
        return $createdCity;
    }

    #[Depends('testCityCreation')]
    /** @throws VetmanagerApiGatewayException */
    public function testCityUpdate(ActiveRecord\City\City $createdCity)
    {
        $updatedCity = $createdCity->setTypeId(2);
        $this->assertEquals(["type_id" => "2"], $updatedCity->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => (string)$createdCity->getId(), "title" => $createdCity->getTitle(), "type_id" => "2"], $updatedCity->getAsArray());
        $newUpdatedCity = $updatedCity->update();
        $this->assertEmpty($newUpdatedCity->getAsArrayWithSetPropertiesOnly());
        $this->assertEquals(["id" => (string)$createdCity->getId(), "title" => $createdCity->getTitle(), "type_id" => "2"], $newUpdatedCity->getAsArray());
        return $newUpdatedCity;
    }

    #[Depends('testCityUpdate')]
    /** @throws VetmanagerApiGatewayException */
    public function testCityDelete(ActiveRecord\City\City $newUpdatedCity)
    {
        $newUpdatedCity->delete();
        $this->expectException(VetmanagerApiGatewayResponseException::class);// Второе удаление - исключение (ведь уже удален)
        $newUpdatedCity->delete();
    }
}
