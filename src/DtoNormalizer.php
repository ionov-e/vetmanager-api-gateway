<?php

namespace VetmanagerApiGateway;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @internal
 */
class DtoNormalizer
{
    public function __construct(private readonly Serializer $serializer)
    {
    }

    public static function withDefaultSerializer(): self
    {
        return new self (self::getDefaultSerializerForNormalization());
    }

    /** Используется при normalize методе. Может использоваться при сериализации */
    public static function getDefaultSerializerForNormalization(): Serializer
    {
        return new Serializer(
            [
                new ArrayDenormalizer(),
                new PropertyNormalizer(defaultContext: [PropertyNormalizer::NORMALIZE_VISIBILITY]),
            ],
            [
                new JsonEncoder(),
            ]);
    }


    /**
     * Возвращает модель в виде массива
     *
     * @return \ArrayObject|array|null|scalar
     * @throws VetmanagerApiGatewayInnerException
     *
     */
    public function getAsArray(AbstractDTO $modelDto)
    {
        try {
            $return = $this->serializer->normalize($modelDto, context: [AbstractNormalizer::IGNORED_ATTRIBUTES => ['propertiesSet']]);
            if (is_array($return)) {
                return $return;
            }
        } catch (ExceptionInterface $ex) {
            $messageFromException = ". Exception: " . $ex->getMessage();
        }
        $additionalInfo = $messageFromException ?? '';
        throw new VetmanagerApiGatewayInnerException("Не получилось получить в виде массива объект класса: " . $modelDto::class . $additionalInfo);
    }

    /**
     * Возвращает модель в виде массива с только записанными клиентом данными (через сеттеры)
     *
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsArrayWithSetPropertiesOnly(AbstractDTO $modelDto): array
    {
        try {
            $return = $this->serializer->normalize($modelDto, context: [AbstractNormalizer::ATTRIBUTES => $modelDto->getPropertiesSet()]);
            if (is_array($return)) {
                return $return;
            }
        } catch (ExceptionInterface $ex) {
            $messageFromException = ". Exception: " . $ex->getMessage();
        }
        $additionalInfo = $messageFromException ?? '';
        throw new VetmanagerApiGatewayInnerException("Не получилось получить в виде массива (только set свойства) объект класса: " . $modelDto::class . $additionalInfo);
    }
}