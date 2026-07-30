<?php

declare(strict_types=1);

namespace App\Domain\FizzBuzz;

final readonly class FizzBuzzResult
{
    /**
     * @param list<string> $values
     */
    public function __construct(
        private array $values,
    ) {
    }

    /**
     * @return list<string>
     */
    public function values(): array
    {
        return $this->values;
    }
}
