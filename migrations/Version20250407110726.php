<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407110726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__book AS SELECT id, book_editor_id, category_id, book_author_id, book_title, book_summary, book_isbn FROM book
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE book
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_editor_id INTEGER NOT NULL, category_id INTEGER NOT NULL, book_author_id INTEGER NOT NULL, book_title VARCHAR(255) NOT NULL, book_summary CLOB NOT NULL, book_isbn INTEGER NOT NULL, CONSTRAINT FK_CBE5A3317B3BBA0A FOREIGN KEY (book_editor_id) REFERENCES editor (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBE5A331E4DBE55D FOREIGN KEY (book_author_id) REFERENCES author (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO book (id, book_editor_id, category_id, book_author_id, book_title, book_summary, book_isbn) SELECT id, book_editor_id, category_id, book_author_id, book_title, book_summary, book_isbn FROM __temp__book
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__book
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CBE5A331E4DBE55D ON book (book_author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CBE5A3317B3BBA0A ON book (book_editor_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE book ADD COLUMN book_author VARCHAR(255) NOT NULL
        SQL);
    }
}
