<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617032910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE submitted_test ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE submitted_test ADD CONSTRAINT FK_1E73FC6B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1E73FC6B9D86650F ON submitted_test (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE submitted_test DROP FOREIGN KEY FK_1E73FC6B9D86650F');
        $this->addSql('DROP INDEX IDX_1E73FC6B9D86650F ON submitted_test');
        $this->addSql('ALTER TABLE submitted_test DROP user_id_id');
    }
}
