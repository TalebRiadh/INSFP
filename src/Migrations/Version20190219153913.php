<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190219153913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news_photo (news_id INT NOT NULL, photo_id INT NOT NULL, INDEX IDX_6E080346B5A459A0 (news_id), INDEX IDX_6E0803467E9E4C8C (photo_id), PRIMARY KEY(news_id, photo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E080346B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_photo ADD CONSTRAINT FK_6E0803467E9E4C8C FOREIGN KEY (photo_id) REFERENCES Photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news DROP importance');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418F00FB71E');
        $this->addSql('DROP INDEX IDX_14B78418F00FB71E ON photo');
        $this->addSql('ALTER TABLE photo DROP news_reference_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D576AB1C14B78418 ON photo (photo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE news_photo');
        $this->addSql('ALTER TABLE news ADD importance INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_D576AB1C14B78418 ON Photo');
        $this->addSql('ALTER TABLE Photo ADD news_reference_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Photo ADD CONSTRAINT FK_14B78418F00FB71E FOREIGN KEY (news_reference_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_14B78418F00FB71E ON Photo (news_reference_id)');
    }
}
