<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502013305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etude_pays (etude_id INT NOT NULL, pays_id INT NOT NULL, INDEX IDX_15E3E7D847ABD362 (etude_id), INDEX IDX_15E3E7D8A6E44244 (pays_id), PRIMARY KEY(etude_id, pays_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etude_pays ADD CONSTRAINT FK_15E3E7D847ABD362 FOREIGN KEY (etude_id) REFERENCES etude (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etude_pays ADD CONSTRAINT FK_15E3E7D8A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE pays_etude');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pays_etude (pays_id INT NOT NULL, etude_id INT NOT NULL, INDEX IDX_1660DC1FA6E44244 (pays_id), INDEX IDX_1660DC1F47ABD362 (etude_id), PRIMARY KEY(pays_id, etude_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pays_etude ADD CONSTRAINT FK_1660DC1F47ABD362 FOREIGN KEY (etude_id) REFERENCES etude (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pays_etude ADD CONSTRAINT FK_1660DC1FA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE etude_pays');
    }
}
