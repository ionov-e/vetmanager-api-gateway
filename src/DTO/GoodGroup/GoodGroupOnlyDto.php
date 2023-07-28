<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodGroup;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class GoodGroupOnlyDto extends AbstractDTO
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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->priceId = ApiInt::fromStringOrNull($originalDataArray['price_id'])->getPositiveIntOrNull();
        $instance->isService = ApiBool::fromStringOrNull($originalDataArray['is_service'])->getBoolOrThrowIfNull();
        $instance->markup = ApiFloat::fromStringOrNull($originalDataArray['markup'])->getNonZeroFloatOrNull();
        $instance->isShowInVaccines = ApiBool::fromStringOrNull($originalDataArray['is_show_in_vaccines'])->getBoolOrThrowIfNull();
        return $instance;
    }

    /** @inheritdoc */
//    protected function getSetValuesWithoutId(): array
//    {
//        return array_merge(
//            property_exists($this, 'title') ? ['title' => $this->title] : [],
//            property_exists($this, 'priceId') ? ['price_id' => $this->priceId] : [],
//            property_exists($this, 'isService') ? ['is_service' => (int)$this->isService] : [],
//            property_exists($this, 'markup') ? ['markup' => $this->markup] : [],
//            property_exists($this, 'isShowInVaccines') ? ['is_show_in_vaccines' => (int)$this->isShowInVaccines] : [],
//        );
//    }
}
