<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\Application\FizzBuzz\Event\FizzBuzzGeneratedEvent;
use App\Application\FizzBuzz\Repository\IncrementFizzBuzzStatisticsRepositoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: FizzBuzzGeneratedEvent::class)]
final readonly class FizzBuzzStatisticsListener
{
    public function __construct(
        private IncrementFizzBuzzStatisticsRepositoryInterface $repository,
    ) {
    }

    public function __invoke(
        FizzBuzzGeneratedEvent $event,
    ): void {
        $this->repository->increment($event->command);
    }
}
