<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
class GoodGroupDto extends AbstractDTO
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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $instance->priceId = IntContainer::fromStringOrNull($originalData['price_id'])->positiveIntOrNull;
        $instance->isService = BoolContainer::fromStringOrNull($originalData['is_service'])->bool;
        $instance->markup = FloatContainer::fromStringOrNull($originalData['markup'])->floatOrNull;
        $instance->isShowInVaccines = BoolContainer::fromStringOrNull($originalData['is_show_in_vaccines'])->bool;
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
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->priceId) ? ['price_id' => $this->priceId] : [],
            isset($this->isService) ? ['is_service' => (int)$this->isService] : [],
            isset($this->markup) ? ['markup' => $this->markup] : [],
            isset($this->isShowInVaccines) ? ['is_show_in_vaccines' => (int)$this->isShowInVaccines] : [],
        );
    }
}
