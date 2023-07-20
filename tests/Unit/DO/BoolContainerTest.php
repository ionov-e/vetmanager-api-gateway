<?php

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(ApiBool::class)]
class BoolContainerTest extends TestCase
{
    public static function dataProviderForStingOrNull(): array
    {
        return [
            [null, null],
            [true, '1'],
            [true, 'true'],
            [true, 'on'],
            [true, 'yes'],
            [false, 'off'],
            [false, '0'],
            [false, 'false'],
            [false, 'no'],
            [false, ''],
        ];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderForStingOrNull')]
    public function testStringOrNullMethod(?bool $expected, ?string $forConstructor, string $messageInCaseOfError = ''): void
    {
        $this->assertEquals(
            $expected,
            ApiBool::fromStringOrNull($forConstructor)->getBoolOrNull(),
            $messageInCaseOfError
        );
    }

    public static function dataProviderForSting(): array
    {
        return [
            [true, '1'],
            [true, 'true'],
            [true, 'on'],
            [true, 'yes'],
            [false, 'off'],
            [false, '0'],
            [false, 'false'],
            [false, 'no'],
            [false, ''],
        ];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderForSting')]
    public function testStringMethod(?bool $expected, ?string $forConstructor, string $messageInCaseOfError = ''): void
    {
        $this->assertEquals(
            $expected,
            ApiBool::fromStringOrNull($forConstructor)->getBoolOrThrowIfNull(),
            $messageInCaseOfError
        );
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        ApiBool::fromStringOrNull(null)->getBoolOrThrowIfNull();
    }
}
