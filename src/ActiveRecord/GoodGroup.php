<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class GoodGroup extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    public int $id;
    public string $title;
    public ?int $priceId;
    /** Default: 0 */
    public bool $isService;
    public ?float $markup;
    /** Default: 0 */
    public bool $isShowInVaccines;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "is_service": string,
     *     "markup": ?string,
     *     "is_show_in_vaccines": string,
     *     "price_id": ?string
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->priceId = IntContainer::fromStringOrNull($originalData['price_id'])->positiveIntOrNull;
        $this->isService = BoolContainer::fromStringOrNull($originalData['is_service'])->bool;
        $this->markup = FloatContainer::fromStringOrNull($originalData['markup'])->floatOrNull;
        $this->isShowInVaccines = BoolContainer::fromStringOrNull($originalData['is_show_in_vaccines'])->bool;
    }

    /** @return ApiModel::GoodGroup */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::GoodGroup;
    }
}
