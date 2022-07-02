<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220702132236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, client_nom VARCHAR(100) NOT NULL, client_prenom VARCHAR(100) NOT NULL, client_raison_sociale VARCHAR(100) NOT NULL, client_siege VARCHAR(100) DEFAULT NULL, client_tel VARCHAR(30) NOT NULL, client_email VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable (id INT AUTO_INCREMENT NOT NULL, tache_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, doc LONGBLOB NOT NULL, INDEX IDX_9E78008CD2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, status VARCHAR(100) NOT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, INDEX IDX_B1BDD6CBC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, budget DOUBLE PRECISION DEFAULT NULL, etat VARCHAR(100) NOT NULL, description VARCHAR(100) DEFAULT NULL, categorie VARCHAR(255) DEFAULT NULL, INDEX IDX_50159CA919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, phase_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, status VARCHAR(100) NOT NULL, priorite DOUBLE PRECISION DEFAULT NULL, date_debut VARCHAR(100) NOT NULL, date_fin VARCHAR(100) DEFAULT NULL, date_affectation VARCHAR(100) DEFAULT NULL, date_modif VARCHAR(100) DEFAULT NULL, INDEX IDX_93872075A76ED395 (user_id), INDEX IDX_9387207599091188 (phase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, date_embauche VARCHAR(100) DEFAULT NULL, image LONGBLOB DEFAULT NULL, matricule VARCHAR(100) DEFAULT NULL, nationalite VARCHAR(100) DEFAULT NULL, sexe VARCHAR(2) NOT NULL, tel VARCHAR(100) DEFAULT NULL, roles JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livrable ADD CONSTRAINT FK_9E78008CD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CBC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207599091188 FOREIGN KEY (phase_id) REFERENCES phase (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA919EB6921');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_9387207599091188');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CBC18272');
        $this->addSql('ALTER TABLE livrable DROP FOREIGN KEY FK_9E78008CD2235D39');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075A76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE livrable');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
