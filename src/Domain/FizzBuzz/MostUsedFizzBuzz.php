<?php

declare(strict_types=1);

namespace App\Domain\FizzBuzz;

final readonly class MostUsedFizzBuzz implements \JsonSerializable
{
    public function __construct(
        private int $int1,
        private int $int2,
        private int $limit,
        private string $str1,
        private string $str2,
        private int $hits,
    ) {
    }

    /**
     * @return array{
     *     int1:int,
     *     int2:int,
     *     limit:int,
     *     str1:string,
     *     str2:string,
     *     hits:int
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'int1' => $this->int1,
            'int2' => $this->int2,
            'limit' => $this->limit,
            'str1' => $this->str1,
            'str2' => $this->str2,
            'hits' => $this->hits,
        ];
    }
}
