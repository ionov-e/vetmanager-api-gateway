<?php

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(ToBool::class)]
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
            ToBool::fromStringOrNull($forConstructor)->getBoolOrNull(),
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
            ToBool::fromStringOrNull($forConstructor)->getBoolOrThrowIfNull(),
            $messageInCaseOfError
        );
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        ToBool::fromStringOrNull(null)->getBoolOrThrowIfNull();
    }
}
