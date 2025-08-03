<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529135738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation ADD offre_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DA7D4E9B4CC8505A ON postulation (offre_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation DROP CONSTRAINT FK_DA7D4E9B4CC8505A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DA7D4E9B4CC8505A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation DROP offre_id
        SQL);
    }
}
