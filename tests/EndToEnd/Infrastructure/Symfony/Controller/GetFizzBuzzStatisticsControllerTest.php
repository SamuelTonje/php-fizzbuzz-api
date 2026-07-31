<?php

declare(strict_types=1);

namespace App\Tests\EndToEnd\Infrastructure\Symfony\Controller;

use App\Tests\EndToEnd\DatabaseTestCase;

final class GetFizzBuzzStatisticsControllerTest extends DatabaseTestCase
{
    public function testReturnsMostUsedStatistics(): void
    {
        $client = static::createClient();
        $client->disableReboot();
        $this->startTransaction();

        // 3 hits
        for ($i = 0; $i < 3; ++$i) {
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
        }

        // 1 hit
        $client->request(
            'POST',
            '/api/fizzbuzz',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'int1' => 2,
                'int2' => 7,
                'limit' => 20,
                'str1' => 'Foo',
                'str2' => 'Bar',
            ], JSON_THROW_ON_ERROR),
        );

        self::assertResponseIsSuccessful();

        $client->request('GET', '/api/fizzbuzz/statistics');

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');

        self::assertJsonStringEqualsJsonString(
            json_encode([
                'int1' => 3,
                'int2' => 5,
                'limit' => 15,
                'str1' => 'Fizz',
                'str2' => 'Buzz',
                'hits' => 3,
            ], JSON_THROW_ON_ERROR),
            $client->getResponse()->getContent(),
        );
    }
}
