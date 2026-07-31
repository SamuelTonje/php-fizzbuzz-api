<?php

declare(strict_types=1);

namespace App\Application\FizzBuzz\Command;

interface FizzBuzzStatisticsRepositoryInterface
{
    public function increment(GenerateFizzBuzzCommand $command): void;
}
