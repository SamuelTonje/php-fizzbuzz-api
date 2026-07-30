<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Command;

use App\Domain\FizzBuzz\FizzBuzzGenerator;
use App\Domain\FizzBuzz\FizzBuzzResult;

final readonly class GenerateFizzBuzzHandler
{
    public function __construct(
        private FizzBuzzGenerator $generator,
    ) {
    }

    public function __invoke(
        GenerateFizzBuzzCommand $command,
    ): FizzBuzzResult {
        return $this->generator->generate(
            int1: $command->int1,
            int2: $command->int2,
            limit: $command->limit,
            str1: $command->str1,
            str2: $command->str2,
        );
    }
}
