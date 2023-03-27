<?php declare(strict_types=1);

namespace VetmanagerApiGateway\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\DTO\FullPhone;

#[CoversClass(FullPhone::class)]
class FullPhoneTest extends TestCase
{
    public static function casesProvider(): array
    {
        return [
            ['38', '0661234567', '(___)___-__-__', '+38(066)123-45-67'],
            ['7', '9181234567', '(___)___-__-__', '+7(918)123-45-67'],
            ['7', '181234567', '(__)___-____', '+7(18)123-4567'],
            ['7', '12345678', '____-____', '+71234-5678'],
            ['', '12345678', '____-____', '1234-5678'],
            ['', '0661234567', '(___)___-__-__', '(066)123-45-67'],
            ['7', '9181234567', '', '+79181234567'],
            ['38', '', '(___)___-__-__', ''],
            ['7', '', '(___)___-__-__', ''],
            ['7', '', '____-____', ''],
        ];
    }

    #[DataProvider('casesProvider')]
    public function testFullMasked(string $countryCode, string $number, string $mask, string $expected, string $messageInCaseOfError = ''): void
    {
        $this->assertEquals(
            (string)new FullPhone($countryCode, $number, $mask),
            $expected,
            $messageInCaseOfError
        );
    }
}
