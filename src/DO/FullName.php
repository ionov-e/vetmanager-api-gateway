<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

class FullName
{
    public function __construct(
        public ?string $first = null,
        public ?string $middle = null,
        public ?string $last = null
    ) {
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            'fullStartingWithFirst' => $this->getFullStartingWithFirst(),
            'fullStartingWithLast' => $this->getFullStartingWithLast(),
            'lastPlusInitials' => $this->getLastPlusInitials(),
            'initials' => $this->getInitials(),
            default => $this->$name,
        };
    }

    /** Возвращает: "Имя Отчество Фамилия"
     * Но если чего-то не будет - вернет без этого слова и без лишних пробелов */
    public function getFullStartingWithFirst(): string
    {
        return $this->getAsStringSeperatedBySpaces($this->first, $this->middle, $this->last);
    }

    private function getAsStringSeperatedBySpaces(...$arguments): string
    {
        return array_reduce(
            $arguments,
            [$this, 'addItemToStringSeperatedBySpaces']
        );
    }

    /** Возвращает: "Фамилия Имя Отчество"
     * Но если чего-то не будет - вернет без этого слова и без лишних пробелов */
    public function getFullStartingWithLast(): string
    {
        return $this->getAsStringSeperatedBySpaces($this->last, $this->first, $this->middle);
    }

    /** Возвращает: "Фамилия И. О."
     * Но если чего-то не будет - вернет без этого слова и без лишних пробелов (и точек) */
    public function getLastPlusInitials(): string
    {
        return $this->getAsStringSeperatedBySpaces(
            $this->last,
            $this->getFirstLetterWithDotOrNothing($this->first),
            $this->getFirstLetterWithDotOrNothing($this->middle)
        );
    }

    private function getFirstLetterWithDotOrNothing(?string $string): string
    {
        return ($string) ? mb_substr($string, 0, 1) . '.' : '';
    }

    /** Возвращает: "Ф. И. О."
     * Но если чего-то не будет - вернет без этого слова и без лишних пробелов (и точек) */
    public function getInitials(): string
    {
        return $this->getAsStringSeperatedBySpaces(
            $this->getFirstLetterWithDotOrNothing($this->last),
            $this->getFirstLetterWithDotOrNothing($this->first),
            $this->getFirstLetterWithDotOrNothing($this->middle)
        );
    }

    private function addItemToStringSeperatedBySpaces(?string $carry, ?string $item): string
    {
        if (empty($item)) {
            return (string)$carry;
        }

        if (empty($carry)) {
            return $item;
        }

        return $carry . " " . $item;
    }
}
