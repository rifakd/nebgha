<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203101924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement CHANGE date_fin date_fin DATETIME DEFAULT NULL, CHANGE lieu lieu VARCHAR(255) DEFAULT NULL, CHANGE frais_participation frais_participation DOUBLE PRECISION DEFAULT NULL, CHANGE tags tags JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE offre CHANGE nom nom VARCHAR(20) DEFAULT NULL, CHANGE date_lancement date_lancement DATETIME DEFAULT NULL, CHANGE date_expiration date_expiration DATETIME DEFAULT NULL, CHANGE prix_original prix_original DOUBLE PRECISION DEFAULT NULL, CHANGE prix_reduit prix_reduit DOUBLE PRECISION DEFAULT NULL, CHANGE pourcentage_reduction pourcentage_reduction DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement CHANGE date_fin date_fin DATETIME DEFAULT \'NULL\', CHANGE lieu lieu VARCHAR(255) DEFAULT \'NULL\', CHANGE frais_participation frais_participation DOUBLE PRECISION DEFAULT \'NULL\', CHANGE tags tags LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE offre CHANGE nom nom VARCHAR(20) DEFAULT \'NULL\', CHANGE date_lancement date_lancement DATETIME DEFAULT \'NULL\', CHANGE date_expiration date_expiration DATETIME DEFAULT \'NULL\', CHANGE prix_original prix_original DOUBLE PRECISION DEFAULT \'NULL\', CHANGE prix_reduit prix_reduit DOUBLE PRECISION DEFAULT \'NULL\', CHANGE pourcentage_reduction pourcentage_reduction DOUBLE PRECISION DEFAULT \'NULL\'');
    }
}
