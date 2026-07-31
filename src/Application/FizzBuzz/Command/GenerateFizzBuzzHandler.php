<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Command;

use App\Application\FizzBuzz\Event\FizzBuzzGeneratedEvent;
use App\Domain\FizzBuzz\FizzBuzzGenerator;
use App\Domain\FizzBuzz\FizzBuzzResult;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class GenerateFizzBuzzHandler
{
    public function __construct(
        private FizzBuzzGenerator $generator,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(
        GenerateFizzBuzzCommand $command,
    ): FizzBuzzResult {
        $fizzBuzzResult = $this->generator->generate(
            int1: $command->int1,
            int2: $command->int2,
            limit: $command->limit,
            str1: $command->str1,
            str2: $command->str2,
        );

        $this->eventDispatcher->dispatch(
            new FizzBuzzGeneratedEvent($command)
        );

        return $fizzBuzzResult;
    }
}
