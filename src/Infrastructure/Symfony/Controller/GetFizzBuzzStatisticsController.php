<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use App\Application\FizzBuzz\Query\GetFizzBuzzStatisticsHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class GetFizzBuzzStatisticsController extends AbstractController
{
    #[OA\Get(
        path: '/api/fizzbuzz/statistics',
        summary: 'Get the most frequently used FizzBuzz parameters',
        tags: ['FizzBuzz']
    )]
    #[OA\Response(
        response: 200,
        description: 'Most frequently used FizzBuzz parameters',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'int1', type: 'integer', example: 3),
                new OA\Property(property: 'int2', type: 'integer', example: 5),
                new OA\Property(property: 'limit', type: 'integer', example: 15),
                new OA\Property(property: 'str1', type: 'string', example: 'Fizz'),
                new OA\Property(property: 'str2', type: 'string', example: 'Buzz'),
                new OA\Property(property: 'hits', type: 'integer', example: 42),
            ],
            type: 'object',
        ),
    )]
    #[OA\Response(
        response: 404,
        description: 'No statistics available',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'message',
                    type: 'string',
                    example: 'No statistics found.'
                ),
            ],
            type: 'object',
        ),
    )]
    #[Route(
        '/api/fizzbuzz/statistics',
        name: 'get_fizzbuzz_statistics',
        methods: ['GET']
    )]
    public function __invoke(
        GetFizzBuzzStatisticsHandler $handler,
    ): JsonResponse {
        $mostUsedFb = ($handler)();

        if (empty($mostUsedFb)) {
            return new JsonResponse(
                ['message' => 'No statistics found.'],
                JsonResponse::HTTP_NOT_FOUND,
            );
        }

        return $this->json($mostUsedFb);
    }
}
