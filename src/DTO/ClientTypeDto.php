<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;

final class ClientTypeDto extends AbstractModelDTO
{
    public function __construct(protected ?string $id, protected ?string $title)
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
    public function setId(int $value): self
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): self
    {
        return self::setPropertyFluently($this, 'title', $value);
    }
}