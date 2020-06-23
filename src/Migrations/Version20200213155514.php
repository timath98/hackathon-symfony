<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213155514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5F7E4ECA3');
        $this->addSql('DROP INDEX IDX_F65593E5F7E4ECA3 ON annonce');
        $this->addSql('ALTER TABLE annonce ADD id_departement_id INT UNSIGNED DEFAULT NULL, DROP id_ville_id');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5F19F5D18 FOREIGN KEY (id_departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5F19F5D18 ON annonce (id_departement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5F19F5D18');
        $this->addSql('DROP INDEX IDX_F65593E5F19F5D18 ON annonce');
        $this->addSql('ALTER TABLE annonce ADD id_ville_id INT UNSIGNED NOT NULL, DROP id_departement_id');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5F7E4ECA3 FOREIGN KEY (id_ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5F7E4ECA3 ON annonce (id_ville_id)');
    }
}
