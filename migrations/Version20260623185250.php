<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623185250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__equipo AS SELECT id, nombre, codigo_tag, fecha_creacion FROM equipo');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('CREATE TABLE equipo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo_tag VARCHAR(255) NOT NULL, fecha_creacion DATE NOT NULL)');
        $this->addSql('INSERT INTO equipo (id, nombre, codigo_tag, fecha_creacion) SELECT id, nombre, codigo_tag, fecha_creacion FROM __temp__equipo');
        $this->addSql('DROP TABLE __temp__equipo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C49C530B3A909126 ON equipo (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C49C530B713A901C ON equipo (codigo_tag)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, nickname, email, rango, equipo_id, edad FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rango VARCHAR(255) NOT NULL, equipo_id INTEGER DEFAULT NULL, edad INTEGER DEFAULT 18 NOT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON UPDATE NO ACTION ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jugador (id, nickname, email, rango, equipo_id, edad) SELECT id, nickname, email, rango, equipo_id, edad FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527D6F18E7927C74 ON jugador (email)');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527D6F18A188FE64 ON jugador (nickname)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__torneo AS SELECT id, nombre, juego, bolsa_premios, estado FROM torneo');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('CREATE TABLE torneo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, juego VARCHAR(255) NOT NULL, bolsa_premios DOUBLE PRECISION NOT NULL, estado VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO torneo (id, nombre, juego, bolsa_premios, estado) SELECT id, nombre, juego, bolsa_premios, estado FROM __temp__torneo');
        $this->addSql('DROP TABLE __temp__torneo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CEB63FE3A909126 ON torneo (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CEB63FEF0EC403D ON torneo (juego)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__equipo AS SELECT id, nombre, codigo_tag, fecha_creacion FROM equipo');
        $this->addSql('DROP TABLE equipo');
        $this->addSql('CREATE TABLE equipo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo_tag VARCHAR(255) NOT NULL, fecha_creacion DATE NOT NULL)');
        $this->addSql('INSERT INTO equipo (id, nombre, codigo_tag, fecha_creacion) SELECT id, nombre, codigo_tag, fecha_creacion FROM __temp__equipo');
        $this->addSql('DROP TABLE __temp__equipo');
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, nickname, email, rango, edad, equipo_id FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rango VARCHAR(255) NOT NULL, edad INTEGER DEFAULT 18 NOT NULL, equipo_id INTEGER DEFAULT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jugador (id, nickname, email, rango, edad, equipo_id) SELECT id, nickname, email, rango, edad, equipo_id FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527D6F18E7927C74 ON jugador (email)');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__torneo AS SELECT id, nombre, juego, bolsa_premios, estado FROM torneo');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('CREATE TABLE torneo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, juego VARCHAR(255) NOT NULL, bolsa_premios DOUBLE PRECISION NOT NULL, estado VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO torneo (id, nombre, juego, bolsa_premios, estado) SELECT id, nombre, juego, bolsa_premios, estado FROM __temp__torneo');
        $this->addSql('DROP TABLE __temp__torneo');
    }
}
