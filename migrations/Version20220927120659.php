<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927120659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_comments ALTER date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE images_comments ALTER update_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN images_comments.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN images_comments.update_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_comments ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE images_comments ALTER update_date TYPE DATE');
        $this->addSql('COMMENT ON COLUMN images_comments.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN images_comments.update_date IS \'(DC2Type:date_immutable)\'');
    }
}
