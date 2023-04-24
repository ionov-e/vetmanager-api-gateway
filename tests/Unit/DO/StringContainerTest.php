<?php

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(StringContainer::class)]
class StringContainerTest extends TestCase
{
    public static function dataProviderForStingOrNull(): array
    {
        return [
            [null, null],
            ['Hello1', 'Hello1'],
        ];
    }

    #[DataProvider('dataProviderForStingOrNull')]
    public function testStringOrNullMethod(?string $forConstructor, ?string $expected, string $messageInCaseOfError = ''): void
    {
        $this->assertEquals(
            $expected,
            StringContainer::fromStringOrNull($forConstructor)->stringOrNull,
            $messageInCaseOfError
        );
    }

    public static function dataProviderForSting(): array
    {
        return [
            [null, ''],
            ['Hello1', 'Hello1'],
        ];
    }

    #[DataProvider('dataProviderForSting')]
    public function testStringMethod(?string $stringOrNull, ?string $expected, string $messageInCaseOfError = ''): void
    {
        $this->assertEquals(
            $expected,
            StringContainer::fromStringOrNull($stringOrNull)->string,
            $messageInCaseOfError
        );
    }

    public function testStringOrThrowIfNullMethod(): void
    {
        $this->assertEquals('Hello1', StringContainer::fromStringOrNull('Hello1')->stringOrThrowIfNull);
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        StringContainer::fromStringOrNull(null)->stringOrThrowIfNull;
    }

    public function testNonEmptyStringMethod(): void
    {
        $this->assertEquals('Hello1', StringContainer::fromStringOrNull('Hello1')->nonEmptyString);
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        StringContainer::fromStringOrNull('')->nonEmptyString;
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        StringContainer::fromStringOrNull(null)->nonEmptyString;
    }
}
