<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Cassa;

use VetmanagerApiGateway\DTO\AbstractDTO;

/**
 * CREATE TABLE `cassa` (
 * `id` int NOT NULL AUTO_INCREMENT,
 * `title` varchar(255) DEFAULT NULL,
 * `assigned_user_id` int NOT NULL,
 * `inventarization_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `client_cass` tinyint(1) DEFAULT '0',
 * `main_cassa` tinyint NOT NULL DEFAULT '0',
 * `is_blocked` int NOT NULL DEFAULT '0',
 * `has_unfinished_docs` int NOT NULL DEFAULT '0',
 * `status` enum('active','deactivated','deleted') NOT NULL DEFAULT 'active',
 * `clinic_id` int NOT NULL DEFAULT '0',
 * `summa_cash` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * `summa_cashless` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * `is_system` int NOT NULL DEFAULT '0',
 * `show_in_cashflow` int NOT NULL DEFAULT '1',
 * `type` enum('bank','safe','operating') NOT NULL DEFAULT 'safe',
 * `cashless_to_cassa_id` int NOT NULL DEFAULT '0',
 * PRIMARY KEY (`id`),
 * UNIQUE KEY `pk_cassa_title1` (`title`),
 * KEY `i_cassa_clinic_id` (`clinic_id`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3
 */
class CassaOnlyDto extends AbstractDTO
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param int|string|null $assigned_user_id
     * @param string|null $inventarization_date
     * @param int|string|null $client_cass
     * @param int|string|null $mainCassa
     * @param int|string|null $isBlocked
     * @param int|string|null $hasUnfinishedDocs
     * @param string|null $status
     * @param int|string|null $clinicId
     * @param string|null $summaCash
     * @param string|null $summaCashless
     * @param int|string|null $isSystem
     * @param int|string|null $showInCashflow
     * @param string|null $type
     * @param int|string|null $cashlessToCassaId
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $title,
        public int|string|null $assigned_user_id,
        public ?string         $inventarization_date,
        public int|string|null $client_cass,
        public int|string|null $mainCassa,
        public int|string|null $isBlocked,
        public int|string|null $hasUnfinishedDocs,
        public ?string         $status,
        public int|string|null $clinicId,
        public ?string         $summaCash,
        public ?string         $summaCashless,
        public int|string|null $isSystem,
        public int|string|null $showInCashflow,
        public ?string         $type,
        public int|string|null $cashlessToCassaId
    )
    {
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAssignedUserid(): int|string|null
    {
        return $this->assigned_user_id;
    }

    public function getInventarizationDate(): ?string
    {
        return $this->inventarization_date;
    }

    public function getClientCass(): int|string|null
    {
        return $this->client_cass;
    }

    public function getMainCassa(): int|string|null
    {
        return $this->mainCassa;
    }

    public function getIsBlocked(): int|string|null
    {
        return $this->isBlocked;
    }

    public function getHasUnfinishedDocs(): int|string|null
    {
        return $this->hasUnfinishedDocs;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getClinicId(): int|string|null
    {
        return $this->clinicId;
    }

    public function getSummaCash(): ?string
    {
        return $this->summaCash;
    }

    public function getSummaCashless(): ?string
    {
        return $this->summaCashless;
    }

    public function getIsSystem(): int|string|null
    {
        return $this->isSystem;
    }

    public function getShowInCashflow(): int|string|null
    {
        return $this->showInCashflow;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getCashlessToCassaId(): int|string|null
    {
        return $this->cashlessToCassaId;
    }

    public function setId(int|string|null $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setAssignedUserid(int|string|null $assigned_user_id): static
    {
        $this->assigned_user_id = $assigned_user_id;
        return $this;
    }

    public function setInventarizationDate(?string $inventarization_date): static
    {
        $this->inventarization_date = $inventarization_date;
        return $this;
    }

    public function setClientCass(int|string|null $client_cass): static
    {
        $this->client_cass = $client_cass;
        return $this;
    }

    public function setMainCassa(int|string|null $mainCassa): static
    {
        $this->mainCassa = $mainCassa;
        return $this;
    }

    public function setIsBlocked(int|string|null $isBlocked): static
    {
        $this->isBlocked = $isBlocked;
        return $this;
    }

    public function setHasUnfinishedDocs(int|string|null $hasUnfinishedDocs): static
    {
        $this->hasUnfinishedDocs = $hasUnfinishedDocs;
        return $this;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function setClinicId(int|string|null $clinicId): static
    {
        $this->clinicId = $clinicId;
        return $this;
    }

    public function setSummaCash(?string $summaCash): static
    {
        $this->summaCash = $summaCash;
        return $this;
    }

    public function setSummaCashless(?string $summaCashless): static
    {
        $this->summaCashless = $summaCashless;
        return $this;
    }

    public function setIsSystem(int|string|null $isSystem): static
    {
        $this->isSystem = $isSystem;
        return $this;
    }

    public function setShowInCashflow(int|string|null $showInCashflow): static
    {
        $this->showInCashflow = $showInCashflow;
        return $this;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function setCashlessToCassaId(int|string|null $cashlessToCassaId): static
    {
        $this->cashlessToCassaId = $cashlessToCassaId;
        return $this;
    }
}