<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class ComboManualName extends DTO\ComboManualName implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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

//    /** @param string $name Имя */
//    public static function fromApiAndName(ApiGateway $apiGateway, string $name): int #TODO
//    {
//
//    }

    /**
     * @return ComboManualItem[]
     * @throws VetmanagerApiGatewayException
     */
    private function getComboManualItems(): array
    {
        /** @see parent::$originalData */
        $comboManualNameArray = parent::getOriginalArray();

        return array_map(
            fn (array $comboManualItemDecodedJson): ComboManualItem => ComboManualItem::fromDecodedJson(
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
