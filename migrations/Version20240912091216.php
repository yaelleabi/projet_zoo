<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240912091216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD habitat_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F20AE7A39 FOREIGN KEY (habitat_id_id) REFERENCES habitat (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F20AE7A39 ON animal (habitat_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F20AE7A39');
        $this->addSql('DROP INDEX IDX_6AAB231F20AE7A39 ON animal');
        $this->addSql('ALTER TABLE animal DROP habitat_id_id');
    }
}