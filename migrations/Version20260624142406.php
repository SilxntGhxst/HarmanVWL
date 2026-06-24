<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260624142406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__torneo AS SELECT id, nombre, juego, bolsa_premios, estado FROM torneo');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('CREATE TABLE torneo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, juego VARCHAR(255) NOT NULL, bolsa_premios DOUBLE PRECISION NOT NULL, estado VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO torneo (id, nombre, juego, bolsa_premios, estado) SELECT id, nombre, juego, bolsa_premios, estado FROM __temp__torneo');
        $this->addSql('DROP TABLE __temp__torneo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CEB63FE3A909126 ON torneo (nombre)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__torneo AS SELECT id, nombre, juego, bolsa_premios, estado FROM torneo');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('CREATE TABLE torneo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, juego VARCHAR(255) NOT NULL, bolsa_premios DOUBLE PRECISION NOT NULL, estado VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO torneo (id, nombre, juego, bolsa_premios, estado) SELECT id, nombre, juego, bolsa_premios, estado FROM __temp__torneo');
        $this->addSql('DROP TABLE __temp__torneo');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CEB63FE3A909126 ON torneo (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7CEB63FEF0EC403D ON torneo (juego)');
    }
}
