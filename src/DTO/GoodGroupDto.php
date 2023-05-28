<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class GoodGroupDto extends AbstractDTO
{
    /** @var positive-int */
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
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->string;
        $instance->priceId = ApiInt::fromStringOrNull($originalDataArray['price_id'])->positiveIntOrNull;
        $instance->isService = ApiBool::fromStringOrNull($originalDataArray['is_service'])->bool;
        $instance->markup = ApiFloat::fromStringOrNull($originalDataArray['markup'])->floatOrNull;
        $instance->isShowInVaccines = ApiBool::fromStringOrNull($originalDataArray['is_show_in_vaccines'])->bool;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
    {
        return [];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            property_exists($this, 'title') ? ['title' => $this->title] : [],
            property_exists($this, 'priceId') ? ['price_id' => $this->priceId] : [],
            property_exists($this, 'isService') ? ['is_service' => (int)$this->isService] : [],
            property_exists($this, 'markup') ? ['markup' => $this->markup] : [],
            property_exists($this, 'isShowInVaccines') ? ['is_show_in_vaccines' => (int)$this->isShowInVaccines] : [],
        );
    }
}
