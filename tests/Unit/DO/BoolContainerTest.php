<?php

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(BoolContainer::class)]
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
            BoolContainer::fromStringOrNull($forConstructor)->boolOrNull,
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
            BoolContainer::fromStringOrNull($forConstructor)->bool,
            $messageInCaseOfError
        );
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        BoolContainer::fromStringOrNull(null)->bool;
    }
}
