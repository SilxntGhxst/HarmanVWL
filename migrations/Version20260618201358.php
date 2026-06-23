<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260618201358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo_tag VARCHAR(255) NOT NULL, fecha_creacion DATE NOT NULL)');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rango VARCHAR(255) NOT NULL, equipo_id INTEGER DEFAULT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('CREATE TABLE torneo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, juego VARCHAR(255) NOT NULL, bolsa_premios DOUBLE PRECISION NOT NULL, estado VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE torneo_equipo (torneo_id INTEGER NOT NULL, equipo_id INTEGER NOT NULL, PRIMARY KEY (torneo_id, equipo_id), CONSTRAINT FK_F9636112A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F963611223BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F9636112A0139802 ON torneo_equipo (torneo_id)');
        $this->addSql('CREATE INDEX IDX_F963611223BFBED ON torneo_equipo (equipo_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipo');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('DROP TABLE torneo_equipo');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
