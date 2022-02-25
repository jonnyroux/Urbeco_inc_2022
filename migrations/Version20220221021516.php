<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221021516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC18272');
        $this->addSql('ALTER TABLE image CHANGE materiaux_id materiaux_id INT NOT NULL');
        $this->addSql('DROP INDEX projet_id ON image');
        $this->addSql('CREATE INDEX IDX_C53D045FC18272 ON image (projet_id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC18272');
        $this->addSql('ALTER TABLE image CHANGE materiaux_id materiaux_id INT DEFAULT NULL, CHANGE image_url image_url VARCHAR(200) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX idx_c53d045fc18272 ON image');
        $this->addSql('CREATE INDEX projet_id ON image (projet_id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE materiaux CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE projet CHANGE titre titre VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
