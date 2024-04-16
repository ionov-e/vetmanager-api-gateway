# Vetmanager Api Gateway

![Vetmanager Logo](https://vetmanager.ru/wp-content/themes/vetmanager/images/headerLogo.svg)

Помощник для работы с АПИ Ветменеджера. Берет на себя:
1) авторизация;
2) получение данных и представление их в виде объектов и типизированных свойств этих объектов;
3) удобное получения связанных моделей с помощью методов полученных объектов (моделей);
4) отправка новых моделей, редактирование, удаление;
5) удобство для реализации кеширования: возможность предоставление модели в виде массива, и создание модели из массива;
6) унификация работы с моделями вне зависимости от способа получения.

[Используется в основе библиотека для составления Query для АПИ-запросов Vetmanager](https://github.com/otis22/vetmanager-rest-api) -
тут же документация к использованию классов для сложных АПИ-запросов: Builder и PagedQuery

[Vetmanager REST API Docs](https://help.vetmanager.cloud/article/3029)

[Vetmanager REST API Postman Collection](https://www.postman.com/vetmanager/workspace/vetmanager-api/collection/23836400-17133b76-0f52-4bb4-8b38-28a64781074e)

[Официальный сайт Vetmanager.ru](https://vetmanager.ru/)

## Для чего?

С помощью этой библиотеки удобно получать данные с АПИ Ветменеджера. Данные приходят в виде Active Records.
Каждый Active Record связан с одним или с несколькими другими Active Records.
Пример кода:

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$invoice = $apiGateway->getInvoice()->getById(7);      // Получение модели Счета по ID 7
$invoiceDiscount = $invoice->getDiscount();            // Получение скидки из Счета
$petBreedTitle = $invoice->getPetBreed()->getTitle();  // Получение названия типа питомца из счета
$pet = $invoice->getPet();                             // Получение модели Питомца из Счета
$petAlias = $pet->getAlias();                          // Получение клички Питомца из Счета
```

## Установка

```bash
composer require ioncurly/vetmanager-api-gateway
```

## Короткое оглавление

* [Начало работы/Конфигурация подключения](#header_connection)
* [Первоначальное получение объектов](#header_get)
    1. [По ID](#get_by_id)
    2. [Всех](#get_all)
    3. [По Query](#get_by_query)
    4. [Другими способами](#get_by_custom)
* [Создание новых моделей](#header_post)
    1. [С помощью фасада и массива](#post_with_facades)
    2. [С помощью Active Record и сеттеров](#post_with_active_records)
* [Редактирование моделей](#header_put)
    1. [С помощью фасада и массива](#put_with_facades)
    2. [С помощью Active Record и сеттеров](#put_with_active_records)
* [Удаление моделей](#header_delete)
    1. [С помощью фасада и массива](#delete_with_facades)
    2. [С помощью Active Record и сеттеров](#delete_with_active_records)
* [Пример представления данных](#header_dtos)
* [Связанные запросы](#header_interconnections)
* [Работа как с первоначальными массивами, кэширование](#header_decoded_json)
* [Дополнительные особенности](#header_additional)
    1. [Объект FullName](#additional_full_name)
    2. [Объект FullPhone](#additional_full_phone)
    3. [Возможность онлайн записи в клинике](#additional_online_sign_up)
* [Немного об устройстве библиотеки](#additional_info)

## Подробное использование:

### Начало работы/Конфигурация подключения <a id="header_connection" />

Простыми словами, объект ApiGateway - связующее звено с работой с АПИ Ветменеджера. Больше ничего создавать не нужно будет

1. С помощью субдомена и АПИ ключа
    ```php
    $subDomain = 'kras-best';   // субдомен клиники в ветменеджер
    $apiKey = 'xXdfxfsfsdffsf'; // АПИ ключ к домену в ветменеджер
    $isProduction = true;       // рабочий или тестовый сервер будет использоваться
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey($subDomain, $apiKey, $isProduction);
    ```
2. С помощью полного пути к серверу и АПИ ключа
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromFullUrlAndApiKey('https://xxx', 'apiKey', true);
    ```
3. С помощью субдомена, имени АПИ-сервиса и АПИ ключа (для специальных внутренних сервисов)
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndServiceNameAndApiKey('subDomain', 'serviceName', 'apiKey', true);
    ```
4. С помощью полного пути к серверу, имени АПИ-сервиса и АПИ ключа (для специальных внутренних сервисов)
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromFullUrlAndServiceNameAndApiKey('https://xxx', 'serviceName', 'apiKey', true);
    ```

### Первоначальное получение объектов <a id="header_get" /> 

Вся логика получения **Active Record** вынесена в соответсвующий **Facade**. Вот пример получения клиента по ID:
```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$clientFacade = $apiGateway->getClient(); // выделение фасада в переменную лишь для наглядности
$client = $clientFacade->getById(33);
```

То есть в этой библиотеке для каждого вида **Active Record** существует свой **Facade**. В **Facade** выделена логика
работы АПИ-запросов и получения из ответов **Active Record**. Например, в **Facade** для **Active Record** Client содержится
метод получения соответствующего **Active Record** по ID. Так же в **Facade** содержатся и другие методы получения (в том
числе - через более сложные запросы - например, через фильтры).

Существуют **Active Records**, которые могут быть получены лишь с помощью конкретного АПИ-запроса. Например,
MedicalCardByClient можно получить лишь по ID клиента. Недоступные методы получения в соответствующем фасаде просто не существуют

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$medicalCards = $apiGateway->getMedicalCardByClient()->getByClientId(33);
```

#### Получение объекта по ID <a id="get_by_id" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$client = $apiGateway->getClient()->getById(33); 
```

#### Получение всех объектов <a id="get_all" />

Всегда возвращает массив моделей. Даже когда 1 объект получаем - обращаемся к нему через массив.

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$invoices = $apiGateway->getInvoice()->getAll(maxLimitOfReturnedModels: 20); // В параметре можем дописать лимит возвращаемых моделей (иначе 100 по умолчанию)
if (!empty($invoices)) {
    $invoiceDescription = $invoices[0]->getDescription();
}
```

#### Получение объекта по Query запросу <a id="get_by_query" />

Точно так же как и получение всех моделей, Query запросы всегда возвращают массив объектов. То есть даже когда 1 объект
возвращается - обращаемся к нему через массив.

Ниже перечислены 3 варианта одного и того же запроса

1) С помощью **Query Builder**

    [Ссылка на используемую библиотеку с большим количество примеров использования Builder](https://github.com/otis22/vetmanager-rest-api)
    
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
    $comboManualItems = $apiGateway->getComboManualItem()->getByQueryBuilder(
            (new Otis22\VetmanagerRestApi\Query\Builder())
                ->where('value', '7')
                ->where('combo_manual_id', '1'),
            1 // Опциональный параметр - лимит возвращаемых моделей
    );
    ```
2) С помощью **PagedQuery**

    [Ссылка на используемую библиотеку с большим количество примеров использования PagedQuery](https://github.com/otis22/vetmanager-rest-api)
    
    С помощью этого объекта удобнее работать с пагинацией.
    
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
    $comboManualItems = $apiGateway->getComboManualItem()->getByPagedQuery(
            (new Otis22\VetmanagerRestApi\Query\Builder())
                ->where('value', '7')
                ->where('combo_manual_id', '1')
                ->top(1) // Лимит возвращаемых моделей
    );
    ```

3) С помощью **Get Parameters** в виде строки

    Сюда можно передать все те же Get-параметры, используемые в коллекции Postman. Более подробно о фильтрах, сортировке
    и т.д. здесь - [Vetmanager REST API Docs](https://help.vetmanager.cloud/article/3029)
    
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
    $comboManualItems = $apiGateway->getComboManualItem()->getByGetParametersAsString(
            "filter=[{'property':'combo_manual_id', 'value':'1'},{'property':'value', 'value':'7'}]&limit=1"
    );
    ```

#### Альтернативные способы получения для конкретных моделей <a id="get_by_custom" />

```php
use VetmanagerApiGateway\DTO\ComboManualName\NameEnum;
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$clinicLanguage = $apiGateway->getProperty()->getByClinicIdAndPropertyName($clinicId = 13, $property = 'lang')->getTitle();
$clientMedicalCards = $apiGateway->getMedicalCardByClient()->getByClientId(77);
$petVaccinations = $apiGateway->getMedicalCardAsVaccination()->getByPetId(11);
$admissionType = $apiGateway->getComboManualItem()->getByAdmissionTypeId(11);
$admissionTypeTitle = $admissionType->getTitle(); // Пример использования содержимого модели
$result = $apiGateway->getComboManualItem()->getByAdmissionResultId(11);
$petColor = $apiGateway->getComboManualItem()->getByPetColorId(11);
$vaccineType = $apiGateway->getComboManualItem()->getByVaccineTypeId(11);
$admissionResult13 = $apiGateway->getComboManualItem()->getOneByValueAndComboManualName(13, NameEnum::AdmissionResult);
$admissionResultManual = $apiGateway->getComboManualName()->getByNameAsString('admission_result');
$admissionResultManualId = $apiGateway->getComboManualName()->getIdByNameAsString('admission_result');
$admissionResultManual = $apiGateway->getComboManualName()->getByNameAsEnum(NameEnum::AdmissionResult);
$admissionResultManualId = $apiGateway->getComboManualName()->getIdByNameAsEnum(NameEnum::AdmissionResult);
$clientAdmissions = $apiGateway->getAdmission()->getByClientId(40);
$petAdmissions = $apiGateway->getAdmission()->getByPetId(88);
```

### Создание новых моделей <a id="header_post" />

#### С помощью фасада и массива <a id="post_with_facades" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);

// Отправляет новый город и возвращает объект (соответствующий Active Record) с созданной моделью от АПИ
$newCity = $apiGateway->getCity()->createNewUsingArray(["title" => "New City", "type_id" => "1"]);
echo $newCity->getId(); // Получим новый присвоенный ID. Можно и другие свойства так же получить
```

#### С помощью Active Record и сеттеров <a id="post_with_active_records" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$newEmptyCity = $apiGateway->getCity()->getNewEmpty();
$cityWithSetValues = $newEmptyCity->setTitle("New City")->setTypeId(1);
$newCity = $cityWithSetValues->create();
echo $newCity->getId(); // Получим новый присвоенный ID. Можно и другие свойства так же получить
```

### Редактирование моделей <a id="header_put" />

#### С помощью фасада и массива <a id="put_with_facades" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
// Отправляет массив данных для изменения модели и возвращает объект (соответствующий Active Record) с созданной моделью от АПИ
$updatedCity = $apiGateway->getCity()->updateUsingIdAndArray(13, ["title" => "New City", "type_id" => "1"]);
// В $updatedCity будет модель полученная из ответа по АПИ
echo $updatedCity->getTitle(); // Получим "New City". Можно и другие свойства так же получить
```

#### С помощью Active Record и сеттеров <a id="put_with_active_records" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$city = $apiGateway->getCity()->getById(13);
$updatedCity = $city->setTitle("New City")->update();
// Без вызова update - модель не отправится
// В $updatedCity будет модель полученная из ответа по АПИ
echo $updatedCity->getTitle(); // Получим "New City". Можно и другие свойства так же получить
```

### Удаление моделей <a id="header_delete" />

#### С помощью фасада <a id="delete_with_facades" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$apiGateway->getCity()->delete(13);
```

#### С помощью Active Record <a id="delete_with_active_records" />

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$city = $apiGateway->getCity()->getById(13);
$city->delete();
```

### Пример представления данных модели <a id="header_dtos" />

Получать каждое свойство через гет-метод. Типизация в каждом методе есть

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$client = $apiGateway->getClient()->getById(13);
$clientEmail = $client->getEmail(); // Объявлено, что только строка, возможно пустая
$clientCityId = $client->getCityId(); // Объявлено, что только int или null может прийти
$clientDateRegister = $client->getDateRegisterAsDateTime()?->format('Y-m-d H:i:s'); //dateRegister содержит DateTime (или null, если отсутствует дата)
$clientName = $client->getFullName()->getInitials(); // FullName - вспомогательный объект для удобного форматирования имени
$clientStatus = $client->getStatusAsEnum(); // Возвращается одно из возможных значений соответствующего Enum
```

### Пример связанных запросов <a id="header_interconnections" />

Есть свойства объекта, которые вместо скалярных данных, возвращают другие объекты или массив объектов.

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$client = $apiGateway->getClient()->getById(13);
$clientStreet = $client->getStreet(); // В переменной будет null или Модель Улицы
$streetName = $clientStreet?->getTitle() ?? ''; // Название улицы или пустая строка
$clientPets = $client->getPetsAlive(); // Массив с Моделями Питомцев 
$firstPet = (!empty($client->petsAlive)) ? $clientPets[0] : null; // Будет Питомец или null
$firstPetName = $firstPet?->getColor()?->getTitle() : ''; // Получение названия цвета питомца или пустая строка, если нет
```

#### Пример обращения посложнее:

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true)->getClient()->getById(13)->getMedicalCards();
$firstMedicalCardOfClient = !empty($clientMedicalCards) ? $clientMedicalCards[0] : null;
$middleNameOfFirstMedicalCardDoctor = $firstMedicalCardOfClient?->getUser()?->getMiddleName();
```

Та же запись, но с дополнительными переменными для понимания:

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true); // Получение объекта ApiGateway
$clientFacade = $apiGateway->getClient(); // Получение фасада для моделей Клиента с разными методами для работы с ними
$client = $clientFacade->getById(13); // Получение через АПИ-запрос используя ID модель Клиента (1ый АПИ запрос)
$clientMedicalCards = $client->getMedicalCards(); // Получение всех карт Клиента (2ой АПИ запрос)
$firstMedicalCardOfClient = !empty($clientMedicalCards) ? $clientMedicalCards[0] : null; // Получим первую карту Клиента или null, если нет карт
$firstMedicalCardDoctor = $firstMedicalCardOfClient?->getUser(); // Получение модели Доктора из медицинской карты (3ий запрос)
$middleNameOfFirstMedicalCardDoctor = $firstMedicalCardDoctor?->getMiddleName(); // Получение отчества доктора из первой Карты Клиента

```

### Нормализация объектов (приведение в массив) <a id="header_decoded_json" />

С помощью этих методов несложно реализовать **кеширование** модели.

Каждый раз, когда нужно сделать повторяющийся одинаковый запрос:

1 - Попытаться получить уже закешированный объект в виде массива.

* Если нашелся кеш:

    2 - создать объект из этого кеша.


* Если не нашелся кеш:

    2 - сделать АПИ запрос на получение объекта
    
    3 - в кеш закинуть модель в виде массива для следующей PHP сессии

#### Получение модели в виде массива

Возвращаются данные в том же виде, в котором и были получены по АПИ

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
$clientAsArray = $apiGateway->getClient()->getById(13)->getAsArray();
// Получим массив модели вида: ["id" => "1", "address" => "", "home_phone" => "3322122", ... ]
```

#### Создание объекта из данных в виде массива

1. Получение одного объекта из закешированного массива модели (в виде ['id' => '12', '...' => ...]).
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
    $client = $apiGateway->getClient()->fromSingleModelAsArray($cachedClientAsArray);
    ```
2. Получение массива объектов из массива таких массивов с моделямм
    ```php
    $apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
    $clients = $apiGateway->getClient()->fromMultipleModelsAsArrays($cachedClientAsArray);
    // Дальше продолжаем использовать будто получили массив моделей как обычно
    $firstClientId = $clients[0]->getId();
    ```

### Дополнительные особенности <a id="header_additional" />

#### Вспомогательный объект FullName <a id="additional_full_name" />

Например, у моделей User и Client есть геттер для FullName. У объекта FullName есть методы возвращающие полное имя в
разном формате:

```php
$clientFullName = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true)->getClient()->getById(9)->getFullName();
echo $clientFullName->getFullStartingWithFirst();// Возвращает: "Имя Отчество Фамилия"
echo $clientFullName->getFullStartingWithLast(); // Возвращает: "Фамилия Имя Отчество"
echo $clientFullName->getLastPlusInitials();     // Возвращает: "Фамилия И. О."
echo $clientFullName->getInitials();             // Возвращает: "Ф. И. О."
```

Если, предположим, отчества не будет, то каждый из методов просто пропустит слово без создания лишних пробелов, точек и
т.д.

#### Вспомогательный объект FullPhone <a id="additional_full_phone" />

Например, у модели Клиники есть метод возвращающий FullPhone. У FullPhone есть метод возвращающий телефон с
кодом страны и выбранной маской номера, например в виде: +7(918)-277-21-21

```php
$clinicFullPhone = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true)->getClinic()->getById(9)->getFullPhone();
echo $clinicFullPhone->getAsMaskedWithCountryCode(); // Выведет телефона в виде +7(918)-277-21-21
echo $clinicFullPhone; // То же самое, что и прошлая строка - _toString() вызывает тот же метод
echo $clinicFullPhone->mask; // Подобные маски могут вернуться: '(___)-__-__-__', '(__)___-____' или '____-____'
echo $clinicFullPhone->countryCode; // +7 или +38 и т.д.
```

#### Узнать возможность онлайн записи в клинике <a id="additional_online_sign_up" />

Несколько вариантов. Возвращается bool:

```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true)
$bool1 = $apiGateway->getProperty()->getIsOnlineSigningUpAvailableForClinic(13); // Один АПИ-запрос
$bool2 = $apiGateway->getClinic()->getIsOnlineSigningUpAvailable(13);            // Один АПИ-запрос
$bool3 = $apiGateway->getClinic()->getById(13)->getIsOnlineSigningUpAvailable(); // Два АПИ-запроса
```

### Немного об устройстве библиотеки <a id="additional_info" />

#### Используемые библиотеки

* **Symfony Serializer** - Для создания DTO из массива данных (десериализованный JSON) и обратного процесса (
  нормализации)
* **Guzzle HTTP client** - Для всех используемых запросов
* **vetmanager-rest-api** - Помощник с Query-запросами АПИ Ветменджера


  Только при разработке:
* **PSALM**
* **PHPUnit**

#### Внутренние особенности

Для большинства моделей АПИ Ветменджер кроме запрашиваемой модели отдает и содержимое других связанных моделей.
Это также зависит от вида запроса - например, при запросе по ID обычно приходит наибольшее число связанных моделей.
Для пользователя этой библиотеки это скрыто: в любом случае вне зависимости от какой вида **Active Record** получен - все
методы и связи с другими моделями доступны. А как именно при вызове метода будут получаться данные: из уже полученных данных
или при помощи дополнительного запроса - это тоже берет на себя библиотека.

Вот пример для понимания устройства. Но для использования это вовсе неважно. В использовании каждый из полученных **Active Record**
идентичен (так как обладают одним и тем же набором доступных методов, которые просто реализованы по-разному):
```php
$apiGateway = VetmanagerApiGateway\ApiGateway::fromSubdomainAndApiKey('subDomain', 'apiKey', true);
/** @var VetmanagerApiGateway\Facade\Client $clientFacade Содержит методы связанные с моделью для осуществления АПИ-запросов и созданию Active Records */
$clientFacade = $apiGateway->getClient();
/** @var VetmanagerApiGateway\ActiveRecord\Client\ClientOnly[] $clients Содержит в себе DTO Client и связи со связанным Active Records*/
$clients = $clientFacade->getAll(); 
/** @var VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity $client Содержит в себе DTO для моделей Client, Client Type, City */
$client = $clientFacade->getById(33); 
```

## Разработка

1.  Копируем файл окружения из примера
    ```bash
    cp .env.example .env
    ```
2.  Заполняем `.env`
3.  Устанавливаем библиотеки
    ```bash
    docker compose run php-fpm composer install
    ```
4.  Запуск юнит-тестов
    ```bash
    docker compose run php-fpm composer test-unit
    ```

Можно запускать другие команды, примеры можно посмотреть в `composer.json` в разделе `scripts`. Например:
```bash
docker compose run php-fpm composer style-check
```
