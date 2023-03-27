<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Enum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use DateTime;
use Exception;

#TODO magical properties
class Medcard extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

    public int $id;
    public DateTime $dateCreate;
    public ?DateTime $dateEdit;
    public string $diagnose;
    public string $recommendation;
    /** Invoice ID (таблица invoice) */
    public ?int $invoice;
    /** Тип приема. Здесь
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionType;
    public ?float $weight;
    public ?float $temperature;
    /** Default: 0    LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id */
    public int $meetResultId;
    public string $description;
    /** Default: 0    LEFT JOIN admission ad ON ad.id = m.next_meet_id   */
    public int $nextMeetId;
    /** Default: 0 */
    public int $userId;
    /** Default: 0 */
    public int $creatorId;
    /** Default: 'active' */
    public Enum\MedicalCard\Status $status;
    /** Default: 0
     * Вроде это ID из модуля задач. Пока непонятно */
    public int $callingId;
    /** Default: 0 */
    public int $admissionId;
    public string $diagnoseText;
    public string $diagnoseTypeText;
    /** Default: 0 */
    public int $clinicId;
    public DTO\Pet $pet;

    /** @var array{
     *     "id": string,
     *     "patient_id": string,
     *     "date_create": string,
     *     "date_edit": ?string,
     *     "diagnos": string,
     *     "recomendation": string,
     *     "invoice": ?string,
     *     "admission_type": ?string,
     *     "weight": ?string,
     *     "temperature": ?string,
     *     "meet_result_id": string,
     *     "description": string,
     *     "next_meet_id": string,
     *     "doctor_id": string,
     *     "creator_id": string,
     *     "status": string,
     *     "calling_id": string,
     *     "admission_id": string,
     *     "diagnos_text": ?string,
     *     "diagnos_type_text": ?string,
     *     "clinic_id": string,
     *     "patient": array{
     *          "id": string,
     *          "owner_id": ?string,
     *          "type_id": ?string,
     *          "alias": string,
     *          "sex": ?string,
     *          "date_register": string,
     *          "birthday": ?string,
     *          "note": string,
     *          "breed_id": ?string,
     *          "old_id": ?string,
     *          "color_id": ?string,
     *          "deathnote": ?string,
     *          "deathdate": ?string,
     *          "chip_number": string,
     *          "lab_number": string,
     *          "status": string,
     *          "picture": ?string,
     *          "weight": ?string,
     *          "edit_date": string,
     *          }
     *      } $originalData
     */
    readonly protected array $originalData;

    /** @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->diagnose = (string)$this->originalData['diagnos'];
        $this->recommendation = (string)$this->originalData['recomendation'];
        $this->admissionType = $this->originalData['admission_type'] ? (int)$this->originalData['admission_type'] : null;    #TODO get?
        $this->weight = $this->originalData['weight'] ? (float)$this->originalData['weight'] : null;
        $this->temperature = $this->originalData['temperature'] ? (float)$this->originalData['temperature'] : null;
        $this->meetResultId = (int)$this->originalData['meet_result_id'];    #TODO get?
        $this->userId = (int)$this->originalData['doctor_id'];
        $this->id = (int)$this->originalData['id'];
        $this->invoice = $this->originalData['invoice'] ? (int)$this->originalData['invoice'] : null;
        $this->description = (string)$this->originalData['description'];
        $this->nextMeetId = (int)$this->originalData['next_meet_id'];    #TODO get?
        $this->creatorId = (int)$this->originalData['creator_id'];    #TODO get?
        $this->status = Enum\MedicalCard\Status::from($this->originalData['status']);
        $this->callingId = (int)$this->originalData['calling_id'];
        $this->admissionId = (int)$this->originalData['admission_id'];    #TODO get?
        $this->diagnoseText = (string)$this->originalData['diagnos_text'];
        $this->diagnoseTypeText = (string)$this->originalData['diagnos_type_text'];
        $this->clinicId = (int)$this->originalData['clinic_id'];
        $this->pet = DTO\Pet::fromDecodedJson($this->apiGateway, $this->originalData['patient']);

        try {
            $this->dateEdit = $this->originalData['date_edit'] ? new DateTime($this->originalData['date_edit']) : null;
            $this->dateCreate = new DateTime($this->originalData['date_create']);
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayException($e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'clinic' => $this->clinicId ? Clinic::fromRequestById($this->apiGateway, $this->clinicId) : null,
            'invoice' => $this->invoice ? Invoice::fromRequestById($this->apiGateway, $this->invoice) : null,
            'user' => $this->userId ? User::fromRequestById($this->apiGateway, $this->userId) : null,

//            LEFT JOIN vaccine_pets vp ON vp.medcard_id = m.id AND vp.status != 'deleted'

            default => $this->$name,
        };
    }

    public static function getApiModel(): Enum\ApiRoute
    {
        return Enum\ApiRoute::MedicalCard;
    }
}
