<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190918165911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the Product table';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->connection
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');

        $this->addSql(
            'CREATE TABLE `products` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(50) NULL DEFAULT NULL,
                `customer_id` INT(11) NULL DEFAULT NULL,
                `status` ENUM(\'new\',\'pending\',\'in review\',\'approved\',\'inactive\',\'deleted\') NOT NULL DEFAULT \'new\',
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `deleted_at` DATETIME NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                INDEX `customer_id` (`customer_id`),
                CONSTRAINT `FK_products_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
            )
            COLLATE=\'utf8_general_ci\'
            ENGINE=InnoDB
            ;'
        );

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
