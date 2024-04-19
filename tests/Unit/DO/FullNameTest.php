<?php declare(strict_types=1);

namespace VetmanagerApiGateway\Unit\DO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\DO\FullName;

#[CoversClass(FullName::class)]
class FullNameTest extends TestCase
{
    public static function casesProviderForFullStartingWithLast(): array
    {
        return [
            ['Имя', 'Отчество', 'Фамилия', 'Фамилия Имя Отчество'],
            ['Имя', 'Отчество', '', 'Имя Отчество'],
            ['Имя', '', 'Фамилия', 'Фамилия Имя'],
            ['', 'Отчество', 'Фамилия', 'Фамилия Отчество'],
            ['', '', 'Фамилия', 'Фамилия'],
            ['Имя', '', '', 'Имя'],
            ['', 'Отчество', '', 'Отчество'],
            ['', '', '', ''],
        ];
    }

    public static function casesProviderForFullStartingWithFirst(): array
    {
        return [
            ['Имя', 'Отчество', 'Фамилия', 'Имя Отчество Фамилия'],
            ['Имя', 'Отчество', '', 'Имя Отчество'],
            ['Имя', '', 'Фамилия', 'Имя Фамилия'],
            ['', 'Отчество', 'Фамилия', 'Отчество Фамилия'],
            ['', '', 'Фамилия', 'Фамилия'],
            ['Имя', '', '', 'Имя'],
            ['', 'Отчество', '', 'Отчество'],
            ['', '', '', ''],
        ];
    }

    public static function casesProviderForLastPlusInitials(): array
    {
        return [
            ['Имя', 'Отчество', 'Фамилия', 'Фамилия И. О.'],
            ['Имя', 'Отчество', '', 'И. О.'],
            ['Имя', '', 'Фамилия', 'Фамилия И.'],
            ['', 'Отчество', 'Фамилия', 'Фамилия О.'],
            ['', '', 'Фамилия', 'Фамилия'],
            ['Имя', '', '', 'И.'],
            ['', 'Отчество', '', 'О.'],
            ['', '', '', ''],
        ];
    }

    public static function casesProviderForInitials(): array
    {
        return [
            ['Имя', 'Отчество', 'Фамилия', 'Ф. И. О.'],
            ['Имя', 'Отчество', '', 'И. О.'],
            ['Имя', '', 'Фамилия', 'Ф. И.'],
            ['', 'Отчество', 'Фамилия', 'Ф. О.'],
            ['', '', 'Фамилия', 'Ф.'],
            ['Имя', '', '', 'И.'],
            ['', 'Отчество', '', 'О.'],
            ['', '', '', ''],
        ];
    }

    public static function casesProviderForDisguisedType1(): array
    {
        return [
            ['Имя', 'Отчество', 'Фамилия', 'Имя От** Фа**'],
            ['Имя', 'Отчество', '', 'Имя От**'],
            ['Имя', '', 'Фамилия', 'Имя Фа**'],
            ['', 'Отчество', 'Фамилия', 'От** Фа**'],
            ['', '', 'Фамилия', 'Фа**'],
            ['Имя', '', '', 'Имя'],
            ['', 'Отчество', '', 'От**'],
            ['', '', '', ''],
        ];
    }

    #[DataProvider('casesProviderForFullStartingWithLast')]
    public function testFullStartingWithLast(string $first, string $middle, string $last, string $expected, string $errorMessage = ''): void
    {
        $this->assertEquals(
            $expected,
            (new FullName($first, $middle, $last))->getFullStartingWithLast(),
            $errorMessage
        );
    }

    #[DataProvider('casesProviderForFullStartingWithFirst')]
    public function testFullStartingWithFirst(string $first, string $middle, string $last, string $expected, string $errorMessage = ''): void
    {
        $this->assertEquals(
            $expected,
            (new FullName($first, $middle, $last))->getFullStartingWithFirst(),
            $errorMessage
        );
    }

    #[DataProvider('casesProviderForLastPlusInitials')]
    public function testLastPlusInitials(string $first, string $middle, string $last, string $expected, string $errorMessage = ''): void
    {
        $this->assertEquals(
            $expected,
            (new FullName($first, $middle, $last))->getLastPlusInitials(),
            $errorMessage
        );
    }

    #[DataProvider('casesProviderForInitials')]
    public function testInitials(string $first, string $middle, string $last, string $expected, string $errorMessage = ''): void
    {
        $this->assertEquals(
            $expected,
            (new FullName($first, $middle, $last))->getInitials(),
            $errorMessage
        );
    }

    #[DataProvider('casesProviderForDisguisedType1')]
    public function testAsDisguisedType1(string $first, string $middle, string $last, string $expected, string $errorMessage = ''): void
    {
        $this->assertEquals(
            $expected,
            (new FullName($first, $middle, $last))->getAsDisguisedType1(),
            $errorMessage
        );
    }
}
