<?php

namespace VetmanagerApiGateway\DTO\ComboManualName;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface ComboManualNameOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return non-empty-string BD default: ''
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTitle(): string;

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsReadonly(): bool;

    /** @return non-empty-string BD default: ''
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getName(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsReadonly(bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setName(?string $value): static;
}
