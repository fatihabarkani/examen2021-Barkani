<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211130185442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration attribut genre';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres ADD genre_id INT DEFAULT NULL, DROP genre');
        $this->addSql('ALTER TABLE livres ADD CONSTRAINT FK_927187A44296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_927187A44296D31F ON livres (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres DROP FOREIGN KEY FK_927187A44296D31F');
        $this->addSql('DROP INDEX IDX_927187A44296D31F ON livres');
        $this->addSql('ALTER TABLE livres ADD genre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP genre_id');
    }
}
