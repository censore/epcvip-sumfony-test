<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918165124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the Customers table';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->connection
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');

        $this->addSql(
                'CREATE TABLE `customers` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `firstName` VARCHAR(50) NOT NULL,
                    `lastName` VARCHAR(50) NOT NULL,
                    `dateOfBirth` DATETIME NULL DEFAULT NULL,
                    `status` ENUM(\'new\',\'pending\',\'in review\',\'approved\',\'inactive\',\'deleted\') NOT NULL DEFAULT \'new\',
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    `deleted_at` DATETIME NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                )
                COLLATE=\'utf8_general_ci\'
                ENGINE=InnoDB'
        );

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
