<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\FizzBuzz;

use App\Domain\FizzBuzz\FizzBuzzGenerator;
use PHPUnit\Framework\TestCase;

final class FizzBuzzGeneratorTest extends TestCase
{
    public function testGenerateStandardFizzbuzzSequence(): void
    {
        $result = FizzBuzzGenerator::generate(
            3,
            5,
            15,
            'Fizz',
            'Buzz',
        );

        self::assertSame(
            [
                '1',
                '2',
                'Fizz',
                '4',
                'Buzz',
                'Fizz',
                '7',
                '8',
                'Fizz',
                'Buzz',
                '11',
                'Fizz',
                '13',
                '14',
                'FizzBuzz',
            ],
            $result->values(),
        );
    }

    public function testGenerateWithCustomRules(): void
    {
        $result = FizzBuzzGenerator::generate(
            2,
            4,
            8,
            'Foo',
            'Bar',
        );

        self::assertSame(
            [
                '1',
                'Foo',
                '3',
                'FooBar',
                '5',
                'Foo',
                '7',
                'FooBar',
            ],
            $result->values(),
        );
    }

    public function testGenerateReturnsNumberWhenNoRuleMatches(): void
    {
        $result = FizzBuzzGenerator::generate(
            3,
            5,
            2,
            'Fizz',
            'Buzz',
        );

        self::assertSame(
            [
                '1',
                '2',
            ],
            $result->values(),
        );
    }
}
