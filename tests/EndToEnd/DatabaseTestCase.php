<?php

declare(strict_types=1);

namespace App\Tests\EndToEnd;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class DatabaseTestCase extends WebTestCase
{
    private ?EntityManagerInterface $entityManager = null;

    protected function startTransaction(): void
    {
        $this->entityManager = self::getContainer()
            ->get(EntityManagerInterface::class);

        $connection = $this->entityManager->getConnection();

        if (!$connection->isTransactionActive()) {
            $connection->beginTransaction();
        }
    }

    protected function rollbackTransaction(): void
    {
        if (
            null !== $this->entityManager
            && $this->entityManager->getConnection()->isTransactionActive()
        ) {
            $this->entityManager
                ->getConnection()
                ->rollBack();
        }

        if (null !== $this->entityManager) {
            $this->entityManager->clear();
        }
    }

    protected function tearDown(): void
    {
        try {
            $this->rollbackTransaction();
        } finally {
            parent::tearDown();
        }
    }
}
