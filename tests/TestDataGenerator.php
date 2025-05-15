<?php

declare(strict_types=1);

namespace Tests;

use RuntimeException;

final class TestDataGenerator
{
    public function nationalNumber(int $key = 1): string
    {
        $numbers = [
            '0013542419',
            '0010532129',
            '3240164175',
            '3240175800',
            '3370075024',
        ];
        $this->ensureKeyIsInValidRange($key, 1, count($numbers));

        return $numbers[$key - 1];
    }

    public function sheba(): string
    {
        return 'IR062960000000100324200001';
    }

    public function jalaliDate(int $key = 1): string
    {
        $this->ensureKeyIsInValidRange($key);

        return '1373-10-2' . $key;
    }

    public function mobile(int $key = 1): string
    {
        $this->ensureKeyIsInValidRange($key);

        return '0912345678' . $key;
    }

    public function telephone(int $key = 1): string
    {
        $this->ensureKeyIsInValidRange($key);

        return '0216699112' . $key;
    }

    private function ensureKeyIsInValidRange(int $key, int $from = 1, int $to = 9): void
    {
        if ($key < $from || $key > $to)
        {
            throw new RuntimeException("\$key must be {$from}-{$to}");
        }
    }
}
