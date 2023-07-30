<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ClientType;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;

final class ClientTypeOnlyDto extends AbstractDTO
{
    /**
     * @param string|null $id
     * @param string|null $title
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title
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