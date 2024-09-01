<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830191610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resume_resume_to_company (resume_id INT NOT NULL, resume_to_company_id INT NOT NULL, INDEX IDX_2291563FD262AF09 (resume_id), INDEX IDX_2291563F63DA3F9E (resume_to_company_id), PRIMARY KEY(resume_id, resume_to_company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resume_resume_to_company ADD CONSTRAINT FK_2291563FD262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resume_resume_to_company ADD CONSTRAINT FK_2291563F63DA3F9E FOREIGN KEY (resume_to_company_id) REFERENCES resume_to_company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resume_to_company CHANGE rating rating INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resume_resume_to_company DROP FOREIGN KEY FK_2291563FD262AF09');
        $this->addSql('ALTER TABLE resume_resume_to_company DROP FOREIGN KEY FK_2291563F63DA3F9E');
        $this->addSql('DROP TABLE resume_resume_to_company');
        $this->addSql('ALTER TABLE resume_to_company CHANGE rating rating INT NOT NULL');
    }
}
