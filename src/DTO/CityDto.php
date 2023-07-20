<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class CityDto extends AbstractNewDTO
{
    /** @param string|null $type_id Default: 1 */
    public function __construct(
        protected ?string  $id,
        protected ?string $title,
        protected ?string $type_id
    )
    {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $id): self
    {
        return self::setPropertyFluently($this, 'id', (string)$id);
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $title): self
    {
        return self::setPropertyFluently($this, 'title', $title);
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $type_id): self
    {
        return self::setPropertyFluently($this, 'type_id', (string)$type_id);
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
