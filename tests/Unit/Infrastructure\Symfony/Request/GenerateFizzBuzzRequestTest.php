<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Symfony\Request;

use App\Infrastructure\Symfony\Request\GenerateFizzBuzzRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GenerateFizzBuzzRequestTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testRequestIsValid(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                100,
                'Fizz',
                'Buzz',
            ),
        );

        self::assertCount(0, $violations);
    }

    public function testInt1MustBePositive(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                0,
                5,
                100,
                'Fizz',
                'Buzz',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('int1', $violations[0]->getPropertyPath());
    }

    public function testInt2MustBePositive(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                0,
                100,
                'Fizz',
                'Buzz',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('int2', $violations[0]->getPropertyPath());
    }

    public function testLimitMustBePositive(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                0,
                'Fizz',
                'Buzz',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('limit', $violations[0]->getPropertyPath());
    }

    public function testStr1CannotBeBlank(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                100,
                '',
                'Buzz',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('str1', $violations[0]->getPropertyPath());
    }

    public function testStr2CannotBeBlank(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                100,
                'Fizz',
                '',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('str2', $violations[0]->getPropertyPath());
    }

    public function testStr1CannotExceed255Characters(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                100,
                str_repeat('a', 256),
                'Buzz',
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('str1', $violations[0]->getPropertyPath());
    }

    public function testStr2CannotExceed255Characters(): void
    {
        $violations = $this->validator->validate(
            new GenerateFizzBuzzRequest(
                3,
                5,
                100,
                'Fizz',
                str_repeat('a', 256),
            ),
        );

        self::assertCount(1, $violations);
        self::assertSame('str2', $violations[0]->getPropertyPath());
    }
}
