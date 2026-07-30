<?php

declare(strict_types=1);

namespace App\Tests\EndToEnd\Infrastructure\Symfony\Controller;

use App\Domain\FizzBuzz\FizzBuzzGenerator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GenerateFizzBuzzControllerTest extends WebTestCase
{
    public function testGenerateFizzbuzz(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'int1' => 3,
                'int2' => 5,
                'limit' => 15,
                'str1' => 'Fizz',
                'str2' => 'Buzz',
            ], JSON_THROW_ON_ERROR),
        );

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        self::assertJsonStringEqualsJsonString(
            json_encode([
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
            ], JSON_THROW_ON_ERROR),
            $client->getResponse()->getContent(),
        );
    }

    public function testReturnsBadRequestWhenBodyIsEmpty(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: '',
        );

        self::assertResponseStatusCodeSame(400);
    }

    public function testReturnsBadRequestWhenJsonIsInvalid(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: '{',
        );

        self::assertResponseStatusCodeSame(400);
    }

    public function testReturnsValidationErrors(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'int1' => 0,
                'int2' => 5,
                'limit' => 15,
                'str1' => 'Fizz',
                'str2' => 'Buzz',
            ], JSON_THROW_ON_ERROR),
        );

        self::assertResponseStatusCodeSame(422);
    }

    #[DataProvider('divisorsProvider')]
    public function testGenerateFizzbuzzWithDivisors(
        int $int1,
        int $int2,
    ): void {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'int1' => $int1,
                'int2' => $int2,
                'limit' => $limit = 6,
                'str1' => $str1 = 'Fizz',
                'str2' => $str2 = 'Buzz',
            ], JSON_THROW_ON_ERROR),
        );

        if (0 === $int1 || 0 === $int2) {
            self::assertResponseStatusCodeSame(422);

            return;
        }

        self::assertResponseIsSuccessful();

        self::assertJsonStringEqualsJsonString(
            json_encode(
                FizzBuzzGenerator::generate($int1, $int2, $limit, $str1, $str2)->values(),
                JSON_THROW_ON_ERROR
            ),
            $client->getResponse()->getContent(),
        );
    }

    public static function divisorsProvider(): iterable
    {
        for ($int1 = 0; $int1 <= 15; ++$int1) {
            for ($int2 = 0; $int2 <= 15; ++$int2) {
                yield sprintf('%02d-%02d', $int1, $int2) => [
                    $int1,
                    $int2,
                ];
            }
        }
    }
}
