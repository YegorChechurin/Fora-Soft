<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190613213030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE submitted_answer (id INT AUTO_INCREMENT NOT NULL, submitted_test_id_id INT NOT NULL, question_id_id INT NOT NULL, answer VARCHAR(255) NOT NULL, INDEX IDX_F3D7934575B9B106 (submitted_test_id_id), INDEX IDX_F3D793454FAF8F53 (question_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE submitted_answer ADD CONSTRAINT FK_F3D7934575B9B106 FOREIGN KEY (submitted_test_id_id) REFERENCES submitted_test (id)');
        $this->addSql('ALTER TABLE submitted_answer ADD CONSTRAINT FK_F3D793454FAF8F53 FOREIGN KEY (question_id_id) REFERENCES question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE submitted_answer');
    }
}
