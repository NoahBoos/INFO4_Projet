<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410093401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE marked_by_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, book_id INTEGER NOT NULL, reading_status_id INTEGER NOT NULL, CONSTRAINT FK_1EAA2505A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1EAA250516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1EAA2505A0C0446C FOREIGN KEY (reading_status_id) REFERENCES reading_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1EAA2505A76ED395 ON marked_by_user (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1EAA250516A2B381 ON marked_by_user (book_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1EAA2505A0C0446C ON marked_by_user (reading_status_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE marked_by_user
        SQL);
    }
}
