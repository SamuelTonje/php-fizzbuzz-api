<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730214611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename statistic table, improve schema and add unique constraint';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('RENAME TABLE statistic TO fizzbuzz_statistics');

        $this->addSql('
            ALTER TABLE fizzbuzz_statistics
                CHANGE hit hits INT UNSIGNED NOT NULL DEFAULT 1,
                MODIFY first_divisor INT UNSIGNED NOT NULL,
                MODIFY second_divisor INT UNSIGNED NOT NULL,
                MODIFY upper_limit INT UNSIGNED NOT NULL,
                MODIFY first_replacement VARCHAR(255) NOT NULL,
                MODIFY second_replacement VARCHAR(255) NOT NULL
        ');

        $this->addSql('
            CREATE UNIQUE INDEX uniq_fizzbuzz_statistics
            ON fizzbuzz_statistics (
                first_divisor,
                second_divisor,
                upper_limit,
                first_replacement,
                second_replacement
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_fizzbuzz_statistics ON fizzbuzz_statistics');

        $this->addSql('
            ALTER TABLE fizzbuzz_statistics
                CHANGE hits hit INT NOT NULL,
                MODIFY first_divisor INT NOT NULL,
                MODIFY second_divisor INT NOT NULL,
                MODIFY upper_limit INT NOT NULL,
                MODIFY first_replacement VARCHAR(15) NOT NULL,
                MODIFY second_replacement VARCHAR(15) NOT NULL
        ');

        $this->addSql('RENAME TABLE fizzbuzz_statistics TO statistic');
    }
}
