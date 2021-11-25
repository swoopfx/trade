<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914185304 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE training_activation (id INT UNSIGNED AUTO_INCREMENT NOT NULL, training_id INT UNSIGNED DEFAULT NULL, maximum_count INT UNSIGNED NOT NULL, users_awarded_count INT UNSIGNED DEFAULT 0 NOT NULL, startdate DATETIME NOT NULL, enddate DATETIME NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX IDX_A6D6DA11BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_activation ADD CONSTRAINT FK_A6D6DA11BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE training_activation');
    }
}
