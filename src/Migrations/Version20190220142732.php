<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220142732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE news_photos (news_id INT NOT NULL, photos_id INT NOT NULL, INDEX IDX_84DF23ADB5A459A0 (news_id), INDEX IDX_84DF23AD301EC62 (photos_id), PRIMARY KEY(news_id, photos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Photos (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FDAE5EF14B78418 (photo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news_photos ADD CONSTRAINT FK_84DF23ADB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_photos ADD CONSTRAINT FK_84DF23AD301EC62 FOREIGN KEY (photos_id) REFERENCES Photos (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news_photos DROP FOREIGN KEY FK_84DF23AD301EC62');
        $this->addSql('DROP TABLE news_photos');
        $this->addSql('DROP TABLE Photos');
    }
}
