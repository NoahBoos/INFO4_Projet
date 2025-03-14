<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314122121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, book_title, book_summary, book_author, book_isbn FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_editor_id INTEGER NOT NULL, book_title VARCHAR(255) NOT NULL, book_summary CLOB NOT NULL, book_author VARCHAR(255) NOT NULL, book_isbn INTEGER NOT NULL, CONSTRAINT FK_CBE5A3317B3BBA0A FOREIGN KEY (book_editor_id) REFERENCES editor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, book_title, book_summary, book_author, book_isbn) SELECT id, book_title, book_summary, book_author, book_isbn FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A3317B3BBA0A ON book (book_editor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, book_title, book_summary, book_author, book_isbn FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_title VARCHAR(255) NOT NULL, book_summary CLOB NOT NULL, book_author VARCHAR(255) NOT NULL, book_isbn INTEGER NOT NULL)');
        $this->addSql('INSERT INTO book (id, book_title, book_summary, book_author, book_isbn) SELECT id, book_title, book_summary, book_author, book_isbn FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
    }
}
