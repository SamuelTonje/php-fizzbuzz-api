<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        match (true) {
            $exception instanceof ValidationFailedException => $this->handleValidationException($event, $exception),
            $exception instanceof \JsonException => $this->handleBadRequest($event, 'Invalid JSON payload.'),
            $exception instanceof ExceptionInterface => $this->handleBadRequest($event, $exception->getMessage()),
            $exception instanceof BadRequestHttpException => $this->handleBadRequest($event, $exception->getMessage()),
            default => null,
        };
    }

    private function handleValidationException(
        ExceptionEvent $event,
        ValidationFailedException $exception,
    ): void {
        $errors = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($exception->getViolations() as $violation) {
            $errors[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        $event->setResponse(
            new JsonResponse(
                [
                    'type' => 'validation_error',
                    'errors' => $errors,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ),
        );
    }

    private function handleBadRequest(
        ExceptionEvent $event,
        string $message,
    ): void {
        $event->setResponse(
            new JsonResponse(
                [
                    'type' => 'bad_request',
                    'message' => $message,
                ],
                Response::HTTP_BAD_REQUEST,
            ),
        );
    }
}
