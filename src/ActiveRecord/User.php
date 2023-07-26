<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\UserDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read UserDto $originalDto
 * @property positive-int $id
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property string $login
 * @property string $password
 * @property positive-int $positionId
 * @property string $email
 * @property string $phone Default: ''
 * @property string $cellPhone Default: ''
 * @property string $address
 * @property ?positive-int $roleId
 * @property bool $isActive
 * @property bool $isPercentCalculated Вообще не понимаю что означает. Default: True
 * @property string $nickname
 * @property ?DateTime $lastChangePwdDate Дата без времени
 * @property bool $isLimited Default: 0
 * @property string $carrotquestId Разного вида строк приходят
 * @property string $sipNumber Default: ''. Самые разные строки могут быть
 * @property string $userInn Default: ''
 * @property-read array{
 *     id: string,
 *     last_name: string,
 *     first_name: string,
 *     middle_name: string,
 *     login: string,
 *     passwd: string,
 *     position_id: string,
 *     email: string,
 *     phone: string,
 *     cell_phone: string,
 *     address: string,
 *     role_id: ?string,
 *     is_active: string,
 *     calc_percents: string,
 *     nickname: ?string,
 *     last_change_pwd_date: string,
 *     is_limited: string,
 *     carrotquest_id: ?string,
 *     sip_number: ?string,
 *     user_inn: string,
 *     position?: array{
 *           id: string,
 *           title: string,
 *           admission_length: string
 *     },
 *     role?: array{
 *           id: string,
 *           name: string,
 *           super: string
 *     }
 * } $originalDataArray
 * @property-read ?Role $role
 * @property-read ?UserPosition $position
 */
final class User extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::User */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::User;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'role':
            case 'position':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'role' => !empty($this->originalDataArray['role'])
                ? Role::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['role'])
                : null,
            'position' => !empty($this->originalDataArray['position'])
                ? UserPosition::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['position'])
                : null,
            'fullName' => new FullName(
                $this->originalDataArray['first_name'],
                $this->originalDataArray['middle_name'],
                $this->originalDataArray['last_name']
            ),
            default => $this->originalDto->$name
        };
    }
}
