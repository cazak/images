<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919111515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "images_authors" (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11713433A188FE64 ON "images_authors" (nickname)');
        $this->addSql('COMMENT ON COLUMN "images_authors".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "images_posts" (id UUID NOT NULL, author_id UUID DEFAULT NULL, avatar VARCHAR(255) NOT NULL, description TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A5655B46F675F31B ON "images_posts" (author_id)');
        $this->addSql('COMMENT ON COLUMN "images_posts".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "images_posts" ADD CONSTRAINT FK_A5655B46F675F31B FOREIGN KEY (author_id) REFERENCES "images_authors" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "images_posts" DROP CONSTRAINT FK_A5655B46F675F31B');
        $this->addSql('DROP TABLE "images_authors"');
        $this->addSql('DROP TABLE "images_posts"');
    }
}
