<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504025048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mark_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, year INTEGER NOT NULL, main_picture VARCHAR(255) NOT NULL, description CLOB NOT NULL, price INTEGER NOT NULL, mileage INTEGER NOT NULL, fuel VARCHAR(255) NOT NULL, puissance INTEGER DEFAULT NULL, cylindre INTEGER DEFAULT NULL, reference VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) NOT NULL, active BOOLEAN DEFAULT NULL, reserved BOOLEAN NOT NULL, CONSTRAINT FK_77E0ED584290F12B FOREIGN KEY (mark_id) REFERENCES mark (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_77E0ED584290F12B ON ad (mark_id)');
        $this->addSql('CREATE TABLE cgv (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE delivery (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE devis (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ad_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_8B27C52B4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8B27C52B4F34D596 ON devis (ad_id)');
        $this->addSql('CREATE TABLE financement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE general_settings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, site_name VARCHAR(255) NOT NULL, site_logo VARCHAR(255) NOT NULL, site_tel VARCHAR(255) NOT NULL, fb_link VARCHAR(255) DEFAULT NULL, whatsapp_link VARCHAR(255) DEFAULT NULL, site_email VARCHAR(255) NOT NULL, site_address VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE images (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ad_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_E01FBE6A4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A4F34D596 ON images (ad_id)');
        $this->addSql('CREATE TABLE mark (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE mentions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE privacy (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE refund (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_title VARCHAR(255) NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE TABLE reviews (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, client_name VARCHAR(255) NOT NULL, reviews_date DATETIME NOT NULL, stars INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP TABLE cgv');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE devis');
        $this->addSql('DROP TABLE financement');
        $this->addSql('DROP TABLE general_settings');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE mentions');
        $this->addSql('DROP TABLE privacy');
        $this->addSql('DROP TABLE refund');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
