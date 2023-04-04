<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ComboManualName extends DTO\ComboManualName implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    /** @var ComboManualItem[] $comboManualItems */
    public array $comboManualItems;
    /** @var array{
     *       "id": string,
     *       "title": string,
     *       "is_readonly": string,
     *       "name": string,
     *       "comboManualItems": array<int, array{
     *                                          "id": string,
     *                                          "combo_manual_id": string,
     *                                          "title": string,
     *                                          "value": string,
     *                                          "dop_param1": string,
     *                                          "dop_param2": string,
     *                                          "dop_param3": string,
     *                                          "is_active": string
     *                                          }
     *                                  >
     *   } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->comboManualItems = $this->getComboManualItems();
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::ComboManualName;
    }

    /**
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function fromName(ApiGateway $apiGateway, string $comboManualName): self
    {
        $comboManualNames = self::fromRequestGetByQueryBuilder($apiGateway, (new Builder())->where("name", $comboManualName), 1);
        return $comboManualNames[0];
    }

    /**
     * @param DTO\Enum\ComboManualName\Name|string $comboManualName Удобней пользоваться Enum, но можно и строкой (напрмер: "admission_type")
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getIdFromName(ApiGateway $apiGateway, DTO\Enum\ComboManualName\Name|string $comboManualName): int
    {
        if ($comboManualName instanceof DTO\Enum\ComboManualName\Name) {
            $comboManualName = $comboManualName->value;
        }

        return self::fromName($apiGateway, $comboManualName)->id;
    }

    /**
     * @return ComboManualItem[]
     * @throws VetmanagerApiGatewayException
     */
    private function getComboManualItems(): array
    {
        /** @see parent::$originalData */
        $comboManualNameArray = parent::getOriginalObjectData();

        return array_map(
            fn(array $comboManualItemDecodedJson): ComboManualItem => ComboManualItem::fromSingleObjectContents(
                $this->apiGateway,
                $comboManualItemDecodedJson
            ),
            array_merge(
                $this->originalData['comboManualItems'],
                ['comboManualName' => $comboManualNameArray]
            )
        );
    }
}
