<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625082854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE added_game (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, game_id_id INT DEFAULT NULL, added_game_date DATETIME NOT NULL, INDEX IDX_7A46E1559D86650F (user_id_id), INDEX IDX_7A46E1554D77E7D8 (game_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id_id INT DEFAULT NULL, post_id_id INT DEFAULT NULL, content_text VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526C69CCBE9A (author_id_id), INDEX IDX_9474526CE85F12B8 (post_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, source_id_id INT DEFAULT NULL, target_id_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content_text VARCHAR(255) NOT NULL, INDEX IDX_B6BD307FE64C4568 (source_id_id), INDEX IDX_B6BD307FC3EF055B (target_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id_id INT DEFAULT NULL, game_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content_text VARCHAR(255) DEFAULT NULL, start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', post_image VARCHAR(255) DEFAULT NULL, INDEX IDX_5A8A6C8D69CCBE9A (author_id_id), INDEX IDX_5A8A6C8D4D77E7D8 (game_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_user (post_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44C6B1424B89032C (post_id), INDEX IDX_44C6B142A76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE added_game ADD CONSTRAINT FK_7A46E1559D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE added_game ADD CONSTRAINT FK_7A46E1554D77E7D8 FOREIGN KEY (game_id_id) REFERENCES games (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C69CCBE9A FOREIGN KEY (author_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE64C4568 FOREIGN KEY (source_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC3EF055B FOREIGN KEY (target_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D69CCBE9A FOREIGN KEY (author_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D4D77E7D8 FOREIGN KEY (game_id_id) REFERENCES games (id)');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B1424B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B142A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE85F12B8');
        $this->addSql('ALTER TABLE post_user DROP FOREIGN KEY FK_44C6B1424B89032C');
        $this->addSql('DROP TABLE added_game');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_user');
    }
}
