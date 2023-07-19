<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class CityDto // extends AbstractDTO
{

    /** @param string|null $type_id Default: 1 */
    public function __construct(
        private string $id,
        private ?string $title,
        private ?string $type_id
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveInt();
    }

    public function setTypeId(string $type_id): self
    {
        $this->type_id = $type_id;
        return $this;
    }
//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     *     "type_id": string,
//     * } $originalDataArray
//     */
//
//    /** @inheritdoc */
//    public function getRequiredKeysForPostArray(): array #TODO check
//    {
//        return ['title', 'type_id'];
//    }
//
//    /** @inheritdoc
//     * @throws VetmanagerApiGatewayRequestException
//     */
//    protected function getSetValuesWithoutId(): array
//    {
//        return (new DtoPropertyList(
//            $this,
//            ['title', 'title'],
//            ['typeId', 'type_id'],
//        ))->toArray();
//    }
}
