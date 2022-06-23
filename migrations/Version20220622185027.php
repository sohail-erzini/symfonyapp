<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622185027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, image LONGBLOB DEFAULT NULL, matricule VARCHAR(100) DEFAULT NULL, sexe VARCHAR(100) NOT NULL, nationalite VARCHAR(100) NOT NULL, tel VARCHAR(100) DEFAULT NULL, date_embauche VARCHAR(100) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe_projet_role (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, projet_id INT DEFAULT NULL, roles JSON DEFAULT NULL, INDEX IDX_2539FB8C1B65292 (employe_id), INDEX IDX_2539FB8CC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable (id INT AUTO_INCREMENT NOT NULL, tache_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, doc LONGBLOB NOT NULL, INDEX IDX_9E78008CD2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, status VARCHAR(100) NOT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, INDEX IDX_B1BDD6CBC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, budget DOUBLE PRECISION DEFAULT NULL, etat VARCHAR(100) NOT NULL, description VARCHAR(100) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, INDEX IDX_50159CA919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, phase_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, status VARCHAR(100) NOT NULL, priorite DOUBLE PRECISION DEFAULT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, date_affectation VARCHAR(100) DEFAULT NULL, date_modif VARCHAR(100) DEFAULT NULL, INDEX IDX_938720751B65292 (employe_id), INDEX IDX_9387207599091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe_projet_role ADD CONSTRAINT FK_2539FB8C1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE employe_projet_role ADD CONSTRAINT FK_2539FB8CC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE livrable ADD CONSTRAINT FK_9E78008CD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CBC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720751B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207599091188 FOREIGN KEY (phase_id) REFERENCES phase (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe_projet_role DROP FOREIGN KEY FK_2539FB8C1B65292');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_938720751B65292');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207599091188');
        $this->addSql('ALTER TABLE employe_projet_role DROP FOREIGN KEY FK_2539FB8CC18272');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CBC18272');
        $this->addSql('ALTER TABLE livrable DROP FOREIGN KEY FK_9E78008CD2235D39');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_projet_role');
        $this->addSql('DROP TABLE livrable');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE tache');
    }
}
