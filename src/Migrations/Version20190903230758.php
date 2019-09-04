<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190903230758 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE platform_update DROP FOREIGN KEY FK_72C22E2524DDC55F');
        $this->addSql('CREATE TABLE php_updates (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', php_version_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', release_version VARCHAR(8) NOT NULL, package_hash VARCHAR(64) NOT NULL, rebuild_version INT NOT NULL, type VARCHAR(30) NOT NULL, status VARCHAR(30) NOT NULL, branch VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F314496A81E24D4 (php_version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE php_updates ADD CONSTRAINT FK_F314496A81E24D4 FOREIGN KEY (php_version_id) REFERENCES php_version (id)');
        $this->addSql('DROP TABLE `update`');
        $this->addSql('ALTER TABLE platform_update DROP FOREIGN KEY FK_72C22E2524DDC55F');
        $this->addSql('ALTER TABLE platform_update ADD CONSTRAINT FK_72C22E2524DDC55F FOREIGN KEY (parent_update_id) REFERENCES php_updates (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE platform_update DROP FOREIGN KEY FK_72C22E2524DDC55F');
        $this->addSql('CREATE TABLE `update` (id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', php_version_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', release_version VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, package_hash VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, rebuild_version INT NOT NULL, type VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, status VARCHAR(30) NOT NULL COLLATE utf8mb4_unicode_ci, branch VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, INDEX IDX_9825357881E24D4 (php_version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `update` ADD CONSTRAINT FK_9825357881E24D4 FOREIGN KEY (php_version_id) REFERENCES php_version (id)');
        $this->addSql('DROP TABLE php_updates');
        $this->addSql('ALTER TABLE platform_update DROP FOREIGN KEY FK_72C22E2524DDC55F');
        $this->addSql('ALTER TABLE platform_update ADD CONSTRAINT FK_72C22E2524DDC55F FOREIGN KEY (parent_update_id) REFERENCES `update` (id)');
    }
}
