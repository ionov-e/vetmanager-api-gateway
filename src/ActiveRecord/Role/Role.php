<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Role;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Role\RoleOnlyDto;
use VetmanagerApiGateway\DTO\Role\RoleOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read array{
// *     id: numeric-string,
// *     name: string,
// *     super: string
// * } $originalDataArray
// */
final class Role extends AbstractActiveRecord implements RoleOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'role';
    }

    public static function getDtoClass(): string
    {
        return RoleOnlyDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, RoleOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Role($this->activeRecordFactory))->createNewUsingArray($this->getAsArray());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Role($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Role($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getName(): string
    {
        return $this->modelDTO->getName();
    }

    /** @inheritDoc */
    public function getIsSuper(): bool
    {
        return $this->modelDTO->getIsSuper();
    }

    /** @inheritDoc */
    public function setName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setName($value));
    }

    /** @inheritDoc */
    public function setIsSuper(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsSuper($value));
    }
}
