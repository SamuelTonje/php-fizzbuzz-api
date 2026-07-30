<?php

declare(strict_types=1);

namespace App\Domain\FizzBuzz;

final readonly class FizzBuzzGenerator
{
    public static function generate(
        int $int1,
        int $int2,
        int $limit,
        string $str1,
        string $str2,
    ): FizzBuzzResult {
        $result = [];

        for ($i = 1; $i <= $limit; ++$i) {
            $value = '';

            if (0 === $i % $int1) {
                $value .= $str1;
            }

            if (0 === $i % $int2) {
                $value .= $str2;
            }

            $result[] = '' !== $value ? $value : (string) $i;
        }

        return new FizzBuzzResult($result);
    }
}
