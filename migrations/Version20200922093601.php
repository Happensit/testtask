<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922093601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE news (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, extid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, image VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD3995094633270 ON news (extid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE news');
    }
}
