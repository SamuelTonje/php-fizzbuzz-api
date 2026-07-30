<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Persistence\Doctrine\Entity;

use App\Infrastructure\Symfony\Persistence\Doctrine\Repository\FizzBuzzStatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(
    name: 'fizzbuzz_statistics',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'uniq_fizzbuzz_statistics',
            columns: [
                'first_divisor',
                'second_divisor',
                'upper_limit',
                'first_replacement',
                'second_replacement',
            ]
        ),
    ]
)]
#[ORM\Entity(repositoryClass: FizzBuzzStatisticsRepository::class)]
class FizzBuzzStatistics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $firstDivisor;

    #[ORM\Column]
    private int $secondDivisor;

    #[ORM\Column]
    private int $upperLimit;

    #[ORM\Column(length: 255)]
    private string $firstReplacement;

    #[ORM\Column(length: 255)]
    private string $secondReplacement;

    #[ORM\Column]
    private int $hits;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstDivisor(): int
    {
        return $this->firstDivisor;
    }

    public function setFirstDivisor(int $firstDivisor): static
    {
        $this->firstDivisor = $firstDivisor;

        return $this;
    }

    public function getSecondDivisor(): int
    {
        return $this->secondDivisor;
    }

    public function setSecondDivisor(int $secondDivisor): static
    {
        $this->secondDivisor = $secondDivisor;

        return $this;
    }

    public function getUpperLimit(): int
    {
        return $this->upperLimit;
    }

    public function setUpperLimit(int $upperLimit): static
    {
        $this->upperLimit = $upperLimit;

        return $this;
    }

    public function getFirstReplacement(): string
    {
        return $this->firstReplacement;
    }

    public function setFirstReplacement(string $firstReplacement): static
    {
        $this->firstReplacement = $firstReplacement;

        return $this;
    }

    public function getSecondReplacement(): string
    {
        return $this->secondReplacement;
    }

    public function setSecondReplacement(string $secondReplacement): static
    {
        $this->secondReplacement = $secondReplacement;

        return $this;
    }

    public function getHits(): int
    {
        return $this->hits;
    }

    public function setHits(int $hits): static
    {
        $this->hits = $hits;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
