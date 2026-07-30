<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GenerateFizzBuzzRequest
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $int1,
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $int2,
        #[Assert\NotNull]
        #[Assert\Positive]
        public int $limit,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $str1,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $str2,
    ) {
    }
}
