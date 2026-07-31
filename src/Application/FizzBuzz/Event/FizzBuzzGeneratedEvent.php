<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Event;

use App\Application\FizzBuzz\Command\GenerateFizzBuzzCommand;

final readonly class FizzBuzzGeneratedEvent
{
    public function __construct(
        public GenerateFizzBuzzCommand $command,
    ) {
    }
}
