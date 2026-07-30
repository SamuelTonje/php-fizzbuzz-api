<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthCheckController
{
    #[Route(
        path: '/health',
        name: 'health_check',
        methods: ['GET']
    )]
    #[OA\Get(
        summary: 'Health check endpoint',
        description: 'Returns application availability status',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Application is healthy',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'status',
                            type: 'string',
                            example: 'ok'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
        ]);
    }
}
