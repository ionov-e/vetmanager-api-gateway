<?php

namespace VetmanagerApiGateway\Hydrator;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\Enum\DtoPropertyMode;

/** @psalm-suppress PropertyNotSetInConstructor */
class DtoPropertyList
{
    /** @var list<array{0: string, 1:string, 2?: DtoPropertyMode}> */
    private array $arrays;

    /** @param list<array{0: string, 1:string, 2?: DtoPropertyMode}> $arrays Первый элемент - название свойства DTO. Второй - ключ в итоговом массиве для значения свойства DTO. Третий - необязательный флаг по какому правилу будем преобразовывать значение из свойства DTO
     * @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */

    public function __construct(
        private readonly AbstractDTO $dto,
        array                        ...$arrays
    ) {
        foreach ($arrays as $array) {
            $this->arrays[] = $array;
        }
    }

    /** @return array<string, null|int|float|string|array>
     * @throws VetmanagerApiGatewayRequestException
     */
    public function toArray(): array
    {
        $resultArray = [];

        foreach ($this->arrays as $array) {

            /** @psalm-suppress DocblockTypeContradiction */
            if (!is_array($array) || !isset($array[0]) || !isset($array[1])) {
                throw new VetmanagerApiGatewayRequestException(
                    __CLASS__ . ": в одном из элементов был не массив с двумя обязательными первыми элементами в виде строк: " . json_encode($array)
                );
            }

            /** @psalm-suppress TypeDoesNotContainType Psalm уверен, что будут строки, потому что так объявлено в PHPDoc*/
            if (!is_string($array[0])) {
                throw new VetmanagerApiGatewayRequestException(
                    __CLASS__ . ":  Вместо название свойства DTO в виде строки получили: " . json_encode($array[0])
                );
            }

            /** @psalm-suppress TypeDoesNotContainType */
            if (!is_string($array[1])) {
                throw new VetmanagerApiGatewayRequestException("Вместо строки для ключа в итоговом массиве получили: " . json_encode($array[1]));
            }

            if ((isset($array[2]) && !$array[2] instanceof DtoPropertyMode)) {
                throw new VetmanagerApiGatewayRequestException(
                    __CLASS__ . ":  Вместо значения Enum в третьем параметре получили: " . json_encode($array[2])
                );
            }

            $arrayKey = $array[1];
            $arrayValue = (new DtoProperty($this->dto, $array[0], $array[2] ?? DtoPropertyMode::Default))->getConvertedValue();

            $resultArray = array_merge(
                $resultArray,
                [$arrayKey => $arrayValue]
            );
        }

        return $resultArray;
    }
}
