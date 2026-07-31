<?php

namespace App\Infrastructure\Symfony\Persistence\Doctrine\Repository;

use App\Application\FizzBuzz\Command\GenerateFizzBuzzCommand;
use App\Application\FizzBuzz\Repository\GetFizzBuzzStatisticsRepositoryInterface;
use App\Application\FizzBuzz\Repository\IncrementFizzBuzzStatisticsRepositoryInterface;
use App\Domain\FizzBuzz\MostUsedFizzBuzz;
use App\Infrastructure\Symfony\Persistence\Doctrine\Entity\FizzBuzzStatistics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FizzBuzzStatistics>
 */
class FizzBuzzStatisticsRepository extends ServiceEntityRepository implements IncrementFizzBuzzStatisticsRepositoryInterface, GetFizzBuzzStatisticsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FizzBuzzStatistics::class);
    }

    public function increment(GenerateFizzBuzzCommand $command): void
    {
        $statistic = $this->findOneBy([
            'firstDivisor' => $command->int1,
            'secondDivisor' => $command->int2,
            'upperLimit' => $command->limit,
            'firstReplacement' => $command->str1,
            'secondReplacement' => $command->str2,
        ]);

        if (null === $statistic) {
            $statistic = new FizzBuzzStatistics();

            $statistic
                ->setFirstDivisor($command->int1)
                ->setSecondDivisor($command->int2)
                ->setUpperLimit($command->limit)
                ->setFirstReplacement($command->str1)
                ->setSecondReplacement($command->str2)
                ->setHits(1)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $this->getEntityManager()->persist($statistic);
        } else {
            $statistic
                ->setHits($statistic->getHits() + 1)
                ->setUpdatedAt(new \DateTimeImmutable());
        }

        $this->getEntityManager()->flush();
    }

    public function findMostUsed(): ?MostUsedFizzBuzz
    {
        $statistics = $this->createQueryBuilder('s')
            ->orderBy('s.hits', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $statistics) {
            return null;
        }

        return new MostUsedFizzBuzz(
            $statistics->getFirstDivisor(),
            $statistics->getSecondDivisor(),
            $statistics->getUpperLimit(),
            $statistics->getFirstReplacement(),
            $statistics->getSecondReplacement(),
            $statistics->getHits(),
        );
    }
}
