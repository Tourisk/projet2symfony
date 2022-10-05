<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005143311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_vehicule (commande_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_FF0FE78782EA2E54 (commande_id), INDEX IDX_FF0FE7874A4A3511 (vehicule_id), PRIMARY KEY(commande_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_vehicule ADD CONSTRAINT FK_FF0FE78782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_vehicule ADD CONSTRAINT FK_FF0FE7874A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4A4A3511');
        $this->addSql('DROP INDEX IDX_6EEAA67D4A4A3511 ON commande');
        $this->addSql('ALTER TABLE commande DROP vehicule_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_vehicule DROP FOREIGN KEY FK_FF0FE78782EA2E54');
        $this->addSql('ALTER TABLE commande_vehicule DROP FOREIGN KEY FK_FF0FE7874A4A3511');
        $this->addSql('DROP TABLE commande_vehicule');
        $this->addSql('ALTER TABLE commande ADD vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4A4A3511 ON commande (vehicule_id)');
    }
}
