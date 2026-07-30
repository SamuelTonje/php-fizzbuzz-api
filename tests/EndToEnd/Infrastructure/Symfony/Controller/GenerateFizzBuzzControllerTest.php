<?php

declare(strict_types=1);

namespace App\Tests\EndToEnd\Infrastructure\Symfony\Controller;

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
}
