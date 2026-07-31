<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Resolver;

use App\Infrastructure\Symfony\Attribute\MapRequestBody;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class RequestBodyValueResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @return iterable<object>
     *
     * @throws \JsonException
     * @throws ExceptionInterface
     */
    public function resolve(
        Request $request,
        ArgumentMetadata $argument,
    ): iterable {
        if (!$argument->getAttributes(MapRequestBody::class, ArgumentMetadata::IS_INSTANCEOF)) {
            return [];
        }

        $type = $argument->getType();

        if (null === $type) {
            return [];
        }

        $content = $request->getContent();

        if ('' === trim($content)) {
            throw new BadRequestHttpException('Request body is empty.');
        }

        $object = $this->serializer->deserialize(
            $content,
            $type,
            'json',
        );

        $violations = $this->validator->validate($object);

        if (0 !== $violations->count()) {
            throw new ValidationFailedException($object, $violations);
        }

        yield $object;
    }
}
