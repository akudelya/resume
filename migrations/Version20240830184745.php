<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830184745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resume_to_company (id INT AUTO_INCREMENT NOT NULL, resume_id INT DEFAULT NULL, company_id INT DEFAULT NULL, rating INT NOT NULL, sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_73574673D262AF09 (resume_id), INDEX IDX_73574673979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resume_to_company ADD CONSTRAINT FK_73574673D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id)');
        $this->addSql('ALTER TABLE resume_to_company ADD CONSTRAINT FK_73574673979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resume_to_company DROP FOREIGN KEY FK_73574673D262AF09');
        $this->addSql('ALTER TABLE resume_to_company DROP FOREIGN KEY FK_73574673979B1AD6');
        $this->addSql('DROP TABLE resume_to_company');
    }
}
