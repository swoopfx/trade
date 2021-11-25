<?php declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910094020 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_submitted_assignment_status (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_submitted_assignment (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status_id INT UNSIGNED DEFAULT NULL, is_disbursed TINYINT(1) DEFAULT NULL, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, userTraining_id INT UNSIGNED DEFAULT NULL, INDEX IDX_C9C16460FC4D2192 (userTraining_id), INDEX IDX_C9C164606BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_submitted_assignment ADD CONSTRAINT FK_C9C16460FC4D2192 FOREIGN KEY (userTraining_id) REFERENCES user_training (id)');
        $this->addSql('ALTER TABLE admin_submitted_assignment ADD CONSTRAINT FK_C9C164606BF700BD FOREIGN KEY (status_id) REFERENCES admin_submitted_assignment_status (id)');
        $this->addSql('DROP TABLE training_maximum_bound');
        $this->addSql('DROP TABLE training_resources');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_submitted_assignment DROP FOREIGN KEY FK_C9C164606BF700BD');
        $this->addSql('CREATE TABLE training_maximum_bound (id INT UNSIGNED AUTO_INCREMENT NOT NULL, training_maximum_name LONGTEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, training_maximum_desc LONGTEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, maximum_registration VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, total_registereed VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE training_resources (id INT UNSIGNED AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE admin_submitted_assignment_status');
        $this->addSql('DROP TABLE admin_submitted_assignment');
    }
}
