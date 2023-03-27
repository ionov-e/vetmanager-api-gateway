# Vetmanager Api Gateway

Помощник для работы с АПИ Ветменеджера.

[Используется в основе библиотека](https://github.com/otis22/vetmanager-rest-api) -
тут же документация к использованию класса Builder для получения PagedQuery

[vetmanager.ru](https://vetmanager.ru/)

[vetmanager REST API Docs](https://help.vetmanager.cloud/article/3029)

[vetmanager REST API in Postman](https://god.postman.co/run-collection/64d692ca1ea129218ccb)

## Пример использования:

```
use VetmanagerApiGateway\ApiGateway;
use Otis22\VetmanagerRestApi\Query\Builder;

$apiGateway = ApiGateway::fromDomainAndServiceNameAndApiKey(
    'subDomainName',
    'serviceName',
    'secretKey',
    true,
);

$client = Client::fromRequestById($apiGateway, 33);
$clientPets = $client->petsAlive;
$allClientMedcards = $client->medcards;

$comboManualItems = ComboManualItem::fromRequestByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('value', '7')
                ->where('combo_manual_id', '1')
                ->top(1)
        );

$comboManualItemTitle = $crmComboManualItems[0]->title;
```
## Пакет будет дополняться и расширяться

Честно.

Как и документация

