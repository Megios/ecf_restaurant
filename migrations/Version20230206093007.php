<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206093007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, ordre SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire_restaurant (id INT AUTO_INCREMENT NOT NULL, jour VARCHAR(255) NOT NULL, ouvert TINYINT(1) NOT NULL, open_midi TIME DEFAULT NULL, close_midi TIME DEFAULT NULL, open_soir TIME DEFAULT NULL, close_soir TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix INT NOT NULL, ordre SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, ordre SMALLINT NOT NULL, INDEX IDX_29A5EC27365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', nom_reservation VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, couvert INT NOT NULL, allergene LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_42C849559B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categorie (id INT AUTO_INCREMENT NOT NULL, carte_id INT NOT NULL, nom VARCHAR(255) NOT NULL, ordre SMALLINT NOT NULL, INDEX IDX_52743D7BC9C7CEB6 (carte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, reservation_name VARCHAR(255) NOT NULL, couvert_default INT DEFAULT NULL, numero_tel VARCHAR(20) NOT NULL, allergene LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559B6B5FBA FOREIGN KEY (account_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BC9C7CEB6 FOREIGN KEY (carte_id) REFERENCES carte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27365BF48');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559B6B5FBA');
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BC9C7CEB6');
        $this->addSql('DROP TABLE carte');
        $this->addSql('DROP TABLE horaire_restaurant');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE sous_categorie');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
