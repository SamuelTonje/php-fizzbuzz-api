<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HealthCheckControllerTest extends WebTestCase
{
    public function testHealthCheck(): void
    {
        $client = static::createClient();

        $client->request('GET', '/health');

        self::assertResponseIsSuccessful();

        self::assertJson($client->getResponse()->getContent());

        self::assertJsonStringEqualsJsonString(
            json_encode([
                'status' => 'ok',
            ], JSON_THROW_ON_ERROR),
            $client->getResponse()->getContent()
        );
    }
}
