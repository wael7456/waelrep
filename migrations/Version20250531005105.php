<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250531005105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation DROP CONSTRAINT fk_da7d4e9b1619db31
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_da7d4e9b1619db31
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation RENAME COLUMN condidat_id TO candidat_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B8D0EB82 FOREIGN KEY (candidat_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DA7D4E9B8D0EB82 ON postulation (candidat_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation DROP CONSTRAINT FK_DA7D4E9B8D0EB82
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DA7D4E9B8D0EB82
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation RENAME COLUMN candidat_id TO condidat_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE postulation ADD CONSTRAINT fk_da7d4e9b1619db31 FOREIGN KEY (condidat_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_da7d4e9b1619db31 ON postulation (condidat_id)
        SQL);
    }
}
