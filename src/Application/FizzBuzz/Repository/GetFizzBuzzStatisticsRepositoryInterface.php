<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Repository;

use App\Domain\FizzBuzz\MostUsedFizzBuzz;

interface GetFizzBuzzStatisticsRepositoryInterface
{
    public function findMostUsed(): ?MostUsedFizzBuzz;
}
