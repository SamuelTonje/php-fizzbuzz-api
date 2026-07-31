<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Query;

use App\Application\FizzBuzz\Repository\GetFizzBuzzStatisticsRepositoryInterface;
use App\Domain\FizzBuzz\MostUsedFizzBuzz;

final readonly class GetFizzBuzzStatisticsHandler
{
    public function __construct(
        private GetFizzBuzzStatisticsRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): ?MostUsedFizzBuzz
    {
        return $this->repository->findMostUsed();
    }
}
