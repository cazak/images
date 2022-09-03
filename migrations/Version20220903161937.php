<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220903161937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user_users" (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, status INT NOT NULL, email VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user_users".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE "user"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, status INT NOT NULL, email VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE "user_users"');
    }
}
