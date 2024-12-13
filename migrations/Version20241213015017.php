<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213015017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT NOT NULL, role_admin VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, sentiment VARCHAR(255) DEFAULT NULL, INDEX IDX_67F068BCDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, description VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devoir (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, score DOUBLE PRECISION NOT NULL, etat TINYINT(1) NOT NULL, nbr_question INT NOT NULL, INDEX IDX_749EA77171C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, date_naissance DATE NOT NULL, niveau_etude VARCHAR(255) NOT NULL, parcour_suivi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, id_prof_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, duree VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cout DOUBLE PRECISION NOT NULL, INDEX IDX_404021BF755C5E8E (id_prof_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_etudiant (formation_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_B6EC75125200282E (formation_id), INDEX IDX_B6EC7512DDEAB1A3 (etudiant_id), PRIMARY KEY(formation_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT NOT NULL, specialite VARCHAR(255) NOT NULL, date_embauche DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, devoir_id INT DEFAULT NULL, intitule VARCHAR(255) DEFAULT NULL, reponse_correcte VARCHAR(255) DEFAULT NULL, choices LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_B6F7494EC583534E (devoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_etudiant (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, reponse_donnee VARCHAR(255) DEFAULT NULL, INDEX IDX_2EF2AD941E27F6BF (question_id), INDEX IDX_2EF2AD94DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, num_tel VARCHAR(20) NOT NULL, role VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE devoir ADD CONSTRAINT FK_749EA77171C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF755C5E8E FOREIGN KEY (id_prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE formation_etudiant ADD CONSTRAINT FK_B6EC75125200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_etudiant ADD CONSTRAINT FK_B6EC7512DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EC583534E FOREIGN KEY (devoir_id) REFERENCES devoir (id)');
        $this->addSql('ALTER TABLE reponse_etudiant ADD CONSTRAINT FK_2EF2AD941E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse_etudiant ADD CONSTRAINT FK_2EF2AD94DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCDDEAB1A3');
        $this->addSql('ALTER TABLE devoir DROP FOREIGN KEY FK_749EA77171C15D5C');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BF396750');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF755C5E8E');
        $this->addSql('ALTER TABLE formation_etudiant DROP FOREIGN KEY FK_B6EC75125200282E');
        $this->addSql('ALTER TABLE formation_etudiant DROP FOREIGN KEY FK_B6EC7512DDEAB1A3');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299BF396750');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EC583534E');
        $this->addSql('ALTER TABLE reponse_etudiant DROP FOREIGN KEY FK_2EF2AD941E27F6BF');
        $this->addSql('ALTER TABLE reponse_etudiant DROP FOREIGN KEY FK_2EF2AD94DDEAB1A3');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE devoir');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_etudiant');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse_etudiant');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
