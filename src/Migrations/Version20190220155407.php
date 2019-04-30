<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220155407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, file VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_63540598C9F3610 (file), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, discription LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_files (news_id INT NOT NULL, files_id INT NOT NULL, INDEX IDX_7C8AC707B5A459A0 (news_id), INDEX IDX_7C8AC707A3E65B2F (files_id), PRIMARY KEY(news_id, files_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_files ADD CONSTRAINT FK_7C8AC707B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_files ADD CONSTRAINT FK_7C8AC707A3E65B2F FOREIGN KEY (files_id) REFERENCES files (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_files DROP FOREIGN KEY FK_7C8AC707A3E65B2F');
        $this->addSql('ALTER TABLE news_files DROP FOREIGN KEY FK_7C8AC707B5A459A0');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_files');
    }
}
