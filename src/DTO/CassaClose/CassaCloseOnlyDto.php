<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CassaClose;

use VetmanagerApiGateway\DTO\AbstractDTO;

/**
 *
 *
 * CREATE TABLE `cassaclose` (
 * `id` int NOT NULL AUTO_INCREMENT,
 * `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
 * `id_cassa` int NOT NULL,
 * `status` enum('exec','save','deleted') NOT NULL DEFAULT 'save',
 * `closed_user_id` int DEFAULT '0',
 * `amount` decimal(25,10) DEFAULT NULL,
 * `amount_cashless` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * PRIMARY KEY (`id`),
 * KEY `fk_id_cassa_closedcassa` (`id_cassa`),
 * KEY `fk_closed_user_id_closedcassa` (`closed_user_id`),
 * CONSTRAINT `fk_closed_user_id_closedcassa` FOREIGN KEY (`closed_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 * CONSTRAINT `fk_id_cassa_closedcassa` FOREIGN KEY (`id_cassa`) REFERENCES `cassa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
 */
class CassaCloseOnlyDto extends AbstractDTO
{
    /**
     * @param int|string|null $id
     * @param string|null $date
     * @param int|string|null $idCassa
     * @param string|null $status
     * @param int|string|null $closedUserId
     * @param string|null $amount
     * @param string|null $amountCashless
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $date,
        public int|string|null $idCassa,
        public ?string         $status,
        public int|string|null $closedUserId,
        public ?string         $amount,
        public ?string         $amountCashless
    )
    {
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getCassaId(): int|string|null
    {
        return $this->idCassa;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getClosedUserId(): int|string|null
    {
        return $this->closedUserId;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function getAmountCashless(): ?string
    {
        return $this->amountCashless;
    }

    public function setId(int|string|null $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setDate(?string $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function setCassaId(int|string|null $idCassa): static
    {
        $this->idCassa = $idCassa;
        return $this;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function setClosedUserId(int|string|null $closedUserId): static
    {
        $this->closedUserId = $closedUserId;
        return $this;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    public function setAmountCashless(?string $amountCashless): static
    {
        $this->amountCashless = $amountCashless;
        return $this;
    }
}