<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use App\Application\FizzBuzz\Command\GenerateFizzBuzzCommand;
use App\Application\FizzBuzz\Command\GenerateFizzBuzzHandler;
use App\Infrastructure\Symfony\Attribute\MapRequestBody;
use App\Infrastructure\Symfony\Request\GenerateFizzBuzzRequest;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/fizzbuzz', methods: ['POST'])]
#[OA\Post(
    path: '/api/fizzbuzz',
    summary: 'Generate a FizzBuzz sequence',
    description: 'Generates a FizzBuzz sequence based on custom divisors and replacement strings.',
    tags: ['FizzBuzz'],
    requestBody: new OA\RequestBody(
        required: true,
        description: 'FizzBuzz generation parameters',
        content: new OA\JsonContent(
            required: ['int1', 'int2', 'limit', 'str1', 'str2'],
            properties: [
                new OA\Property(
                    property: 'int1',
                    description: 'First divisor',
                    type: 'integer',
                    example: 3
                ),
                new OA\Property(
                    property: 'int2',
                    description: 'Second divisor',
                    type: 'integer',
                    example: 5
                ),
                new OA\Property(
                    property: 'limit',
                    description: 'Maximum number of values to generate',
                    type: 'integer',
                    example: 15
                ),
                new OA\Property(
                    property: 'str1',
                    description: 'Replacement string for multiples of int1',
                    type: 'string',
                    example: 'Fizz'
                ),
                new OA\Property(
                    property: 'str2',
                    description: 'Replacement string for multiples of int2',
                    type: 'string',
                    example: 'Buzz'
                ),
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: 'FizzBuzz sequence generated successfully',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(type: 'string'),
                example: [
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
                ]
            )
        ),
        new OA\Response(
            response: 400,
            description: 'Invalid JSON payload'
        ),
        new OA\Response(
            response: 422,
            description: 'Validation errors'
        ),
    ]
)]
final readonly class GenerateFizzBuzzController
{
    public function __construct(
        private GenerateFizzBuzzHandler $handler,
    ) {
    }

    public function __invoke(
        #[MapRequestBody]
        GenerateFizzBuzzRequest $request,
    ): JsonResponse {
        $command = new GenerateFizzBuzzCommand(
            int1: $request->int1,
            int2: $request->int2,
            limit: $request->limit,
            str1: $request->str1,
            str2: $request->str2,
        );

        $response = ($this->handler)($command);

        return new JsonResponse($response->values());
    }
}
