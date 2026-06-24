<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623175231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, nickname, email, rango, equipo_id, edad FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rango VARCHAR(255) NOT NULL, equipo_id INTEGER DEFAULT NULL, edad INTEGER DEFAULT 18 NOT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jugador (id, nickname, email, rango, equipo_id, edad) SELECT id, nickname, email, rango, equipo_id, edad FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_527D6F18E7927C74 ON jugador (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__jugador AS SELECT id, nickname, email, rango, edad, equipo_id FROM jugador');
        $this->addSql('DROP TABLE jugador');
        $this->addSql('CREATE TABLE jugador (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nickname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, rango VARCHAR(255) NOT NULL, edad INTEGER DEFAULT 18 NOT NULL, equipo_id INTEGER DEFAULT NULL, CONSTRAINT FK_527D6F1823BFBED FOREIGN KEY (equipo_id) REFERENCES equipo (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO jugador (id, nickname, email, rango, edad, equipo_id) SELECT id, nickname, email, rango, edad, equipo_id FROM __temp__jugador');
        $this->addSql('DROP TABLE __temp__jugador');
        $this->addSql('CREATE INDEX IDX_527D6F1823BFBED ON jugador (equipo_id)');
    }
}
