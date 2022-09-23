<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922221710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "images_feeds" (id UUID NOT NULL, reader_id UUID DEFAULT NULL, post_id UUID DEFAULT NULL, author_id UUID DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, post_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, post_description TEXT NOT NULL, post_avatar VARCHAR(255) NOT NULL, author_nickname VARCHAR(255) NOT NULL, author_avatar VARCHAR(255) NOT NULL, author_name VARCHAR(255) NOT NULL, author_surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_771114931717D737 ON "images_feeds" (reader_id)');
        $this->addSql('CREATE INDEX IDX_771114934B89032C ON "images_feeds" (post_id)');
        $this->addSql('CREATE INDEX IDX_77111493F675F31B ON "images_feeds" (author_id)');
        $this->addSql('COMMENT ON COLUMN "images_feeds".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "images_feeds".post_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "images_feeds" ADD CONSTRAINT FK_771114931717D737 FOREIGN KEY (reader_id) REFERENCES "images_authors" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "images_feeds" ADD CONSTRAINT FK_771114934B89032C FOREIGN KEY (post_id) REFERENCES "images_posts" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "images_feeds" ADD CONSTRAINT FK_77111493F675F31B FOREIGN KEY (author_id) REFERENCES "images_authors" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "images_feeds" DROP CONSTRAINT FK_771114931717D737');
        $this->addSql('ALTER TABLE "images_feeds" DROP CONSTRAINT FK_771114934B89032C');
        $this->addSql('ALTER TABLE "images_feeds" DROP CONSTRAINT FK_77111493F675F31B');
        $this->addSql('DROP TABLE "images_feeds"');
    }
}
