<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Breed $self
 * @property-read \VetmanagerApiGateway\DTO\DAO\PetType $type
 */
class Admission extends AbstractDTO
{
    public int $id;
    /** Пример "2020-12-31 17:51:18" */
    public DateTime $date;
    /** Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев" */
    public string $description;
    public int $clientId;
    public ?int $patientId;
    public ?int $userId;
    public ?int $typeId;
    /** Примеры: "00:00:00", "00:15:00" */
    public ?DateInterval $admissionLength;
    public ?Status $status;

    /** @var array{
     *          "id": string,
     *          "admission_date": string,
     *          "description": string,
     *          "client_id": string,
     *          "patient_id": string,
     *          "user_id": string,
     *          "type_id": string,
     *          "admission_length": string,
     *          "status": ?string,
     *          "clinic_id": string,
     *          "direct_direction": string,
     *          "creator_id": string,
     *          "create_date": string,
     *          "escorter_id": string,
     *          "reception_write_channel": string,
     *          "is_auto_create": string,
     *          "invoices_sum": string,
     *     } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);
        $this->id = (int)$this->originalData['id'];
    }
}
