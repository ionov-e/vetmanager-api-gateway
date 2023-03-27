<?php declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\FullName;
use VetmanagerApiGateway\Enum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use DateTime;
use Exception;

#TODO magical properties
class MedicalCardsByClient extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

    public int $id;
    public ?DateTime $dateEdit;
    public string $diagnose;
    /** Default: 0 */
    public int $userId;
    /** Default: 'active' */
    public Enum\MedicalCard\Status $status;
    public string $description;
    public string $recommendation;
    public ?float $weight;
    public ?float $temperature;
    /** Default: 0 */
    public int $meetResultId;
    /** {@see Medcard::admissionType} */
    public ?int $admissionType;
    public int $petId;
    public string $petAlias;
    /** Дата без времени */
    public DateTime $petBirthday;
    public Enum\Pet\Sex $petSex;
    public string $petNote;
    public ?string $petTypeTitle;
    public ?string $petBreedTitle;
    public ?int $clientId;
    public FullName $ownerFullName;
    public string $ownerPhone;
    public string $userLogin;
    public FullName $userFullName;
    /** Будет False, если в таблице special_studies_medcard_data будет хоть одна запись с таким же medcard_id {@see self::id}  */
    public bool $isEditable;
    /** Пример: "Повторный прием"
     *
     * В таблице combo_manual_items ищет кортеж с combo_manual_id = 2 и value = {@see self::meetResultId}. Из строки возвращается title
     */
    public string $meetResultTitle;
    /** Пример: "Вакцинация", "Хирургия", "Первичный" или "Вторичный"
     *
     * В таблице combo_manual_items ищет строку с id = {@see self::admissionType} и возвращает значение из столбца title. */
    public string $admissionTypeTitle;

    /** @var array{
     *     "medical_card_id": string,
     *     "date_edit": ?string,
     *     "diagnos": string,
     *     "doctor_id": string,
     *     "medical_card_status": string,
     *     "healing_process": string,
     *     "recomendation": string,
     *     "weight": ?string,
     *     "temperature": ?string,
     *     "meet_result_id": string,
     *     "admission_type": ?string,
     *     "pet_id": string,
     *     "alias": string,
     *     "birthday": ?string,
     *     "sex": string,
     *     "note": string,
     *     "pet_type": string,
     *     "breed": string,
     *     "client_id": string,
     *     "first_name": string,
     *     "last_name": string,
     *     "middle_name": string,
     *     "phone": string,
     *     "doctor_nickname": string,
     *     "doctor_first_name": string,
     *     "doctor_last_name": string,
     *     "doctor_middle_name": string,
     *     "editable": string,
     *     "meet_result_title": string,
     *     "admission_type_title": string
     * } $originalData
     */
    readonly protected array $originalData;

    /** @throws VetmanagerApiGatewayException */
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
        $this->id = (int)$this->originalData['medical_card_id'];
        $this->description = (string)$this->originalData['healing_process'];
        $this->status = Enum\MedicalCard\Status::from($this->originalData['medical_card_status']);
        $this->petId = (int)$this->originalData['pet_id'];
        $this->petAlias = (string)$this->originalData['alias'];
        $this->clientId = $this->originalData['client_id'] ? (int)$this->originalData['client_id'] : null;
        $this->petSex = $this->originalData['sex'] ? Enum\Pet\Sex::from($this->originalData['sex']) : Enum\Pet\Sex::Unknown;
        $this->petNote = $this->originalData['note'] ? (string)$this->originalData['note'] : null;
        $this->petTypeTitle = $this->originalData['pet_type'] ? (string)$this->originalData['pet_type'] : null;
        $this->petBreedTitle = $this->originalData['breed'] ? (string)$this->originalData['breed'] : null;
        $this->ownerFullName = new FullName($this->originalData['first_name'], $this->originalData['middle_name'], $this->originalData['last_name']);
        $this->ownerPhone = (string)$this->originalData['phone'];
        $this->userLogin = (string)$this->originalData['doctor_nickname'];
        $this->userFullName = new FullName($this->originalData['doctor_first_name'], $this->originalData['doctor_middle_name'], $this->originalData['doctor_last_name']);
        $this->isEditable = (bool)$this->originalData['editable'];
        $this->meetResultTitle = (string)$this->originalData['meet_result_title'];
        $this->admissionTypeTitle = (string)$this->originalData['admission_type_title'];

        try {
            $this->dateEdit = $this->originalData['date_edit'] ? new DateTime($this->originalData['date_edit']) : null;
            $this->petBirthday = $this->originalData['birthday'] ? new DateTime($this->originalData['birthday']) : null;
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayException($e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => Medcard::fromRequestById($this->apiGateway, $this->id),
            'admissionType' => $this->admissionType ? ComboManualItem::getAdmissionTypeFromApiAndId($this->apiGateway, $this->admissionType) : null,
            'meetResult' => $this->meetResultId ? ComboManualItem::getAdmissionResultFromApiAndResultId($this->apiGateway, $this->meetResultId) : null,
            'client' => $this->clientId ? Client::fromRequestById($this->apiGateway, $this->clientId) : null,
            'pet' => Pet::fromRequestById($this->apiGateway, $this->petId),
            'user' => $this->userId ? User::fromRequestById($this->apiGateway, $this->userId) : null,
            default => $this->$name,
        };
    }

    public static function getApiModel(): Enum\ApiRoute
    {
        return Enum\ApiRoute::MedicalCardsByClient;
    }
}
