<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220924183739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images_comments (id UUID NOT NULL, post_id UUID DEFAULT NULL, author_id UUID DEFAULT NULL, date DATE NOT NULL, update_date DATE DEFAULT NULL, text TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FCBDEB404B89032C ON images_comments (post_id)');
        $this->addSql('CREATE INDEX IDX_FCBDEB40F675F31B ON images_comments (author_id)');
        $this->addSql('CREATE INDEX IDX_FCBDEB40AA9E377A ON images_comments (date)');
        $this->addSql('COMMENT ON COLUMN images_comments.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN images_comments.update_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE images_comments ADD CONSTRAINT FK_FCBDEB404B89032C FOREIGN KEY (post_id) REFERENCES "images_posts" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images_comments ADD CONSTRAINT FK_FCBDEB40F675F31B FOREIGN KEY (author_id) REFERENCES "images_authors" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_comments DROP CONSTRAINT FK_FCBDEB404B89032C');
        $this->addSql('ALTER TABLE images_comments DROP CONSTRAINT FK_FCBDEB40F675F31B');
        $this->addSql('DROP TABLE images_comments');
    }
}
