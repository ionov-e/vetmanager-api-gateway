<?php

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

#[CoversClass(ToString::class)]
class StringContainerTest extends TestCase
{
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
            ToString::fromStringOrNull($stringOrNull)->getStringEvenIfNullGiven(),
            $messageInCaseOfError
        );
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function testStringOrThrowIfNullMethod(): void
    {
        $this->assertEquals('Hello1', ToString::fromStringOrNull('Hello1')->getStringOrThrowIfNull());
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        ToString::fromStringOrNull(null)->getStringOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function testNonEmptyStringMethod(): void
    {
        $this->assertEquals('Hello1', ToString::fromStringOrNull('Hello1')->getNonEmptyStringOrThrow());
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        ToString::fromStringOrNull('')->getNonEmptyStringOrThrow();
        $this->expectException(VetmanagerApiGatewayResponseException::class);
        ToString::fromStringOrNull(null)->getNonEmptyStringOrThrow();
    }
}
