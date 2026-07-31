<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Repository;

use App\Application\FizzBuzz\Command\GenerateFizzBuzzCommand;

interface IncrementFizzBuzzStatisticsRepositoryInterface
{
    public function increment(GenerateFizzBuzzCommand $command): void;
}
