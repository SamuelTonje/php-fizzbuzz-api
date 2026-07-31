<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\FizzBuzz\Command;

use App\Application\FizzBuzz\Command\GenerateFizzBuzzCommand;
use App\Application\FizzBuzz\Command\GenerateFizzBuzzHandler;
use App\Domain\FizzBuzz\FizzBuzzGenerator;
use App\Domain\FizzBuzz\FizzBuzzResult;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

final class GenerateFizzBuzzHandlerTest extends TestCase
{
    public function testGenerateFizzbuzz(): void
    {
        $handler = new GenerateFizzBuzzHandler(
            new FizzBuzzGenerator(),
            $this->createStub(EventDispatcherInterface::class),
        );

        $command = new GenerateFizzBuzzCommand(
            3,
            5,
            15,
            'Fizz',
            'Buzz',
        );

        $result = $handler($command);

        self::assertInstanceOf(FizzBuzzResult::class, $result);
        self::assertSame(
            [
                1,
                2,
                'Fizz',
                4,
                'Buzz',
                'Fizz',
                7,
                8,
                'Fizz',
                'Buzz',
                11,
                'Fizz',
                13,
                14,
                'FizzBuzz',
            ],
            $result->values(),
        );
    }
}
