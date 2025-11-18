<?php

namespace VetmanagerApiGateway\DTO\UserPosition;

use DateInterval;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface UserPositionOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): ?string;

    /** Default: '00:30:00'. TypeEnum in DB: 'time'. Null if '00:00:00' */
    public function getAdmissionLengthAsString(): ?string;

    /** Default: '00:30:00'. TypeEnum in DB: 'time'. Null if '00:00:00'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAdmissionLengthAsDateInterval(): ?DateInterval;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthFromDateInterval(DateInterval $value): static;
}
