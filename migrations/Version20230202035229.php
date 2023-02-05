<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230202035229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pengambilan (id INT AUTO_INCREMENT NOT NULL, pesanan_id INT NOT NULL, pengambil VARCHAR(25) NOT NULL, jumlah INT NOT NULL, UNIQUE INDEX UNIQ_47B23C33D87C54E2 (pesanan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pesanan (id INT AUTO_INCREMENT NOT NULL, barang_id INT NOT NULL, pemesan VARCHAR(25) NOT NULL, jumlah INT NOT NULL, proses INT NOT NULL, INDEX IDX_80706B5629711AE0 (barang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produksi (id INT AUTO_INCREMENT NOT NULL, pesanan_id INT NOT NULL, jumlah INT NOT NULL, leadtime VARCHAR(25) DEFAULT NULL, UNIQUE INDEX UNIQ_F8A645FD87C54E2 (pesanan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pengambilan ADD CONSTRAINT FK_47B23C33D87C54E2 FOREIGN KEY (pesanan_id) REFERENCES pesanan (id)');
        $this->addSql('ALTER TABLE pesanan ADD CONSTRAINT FK_80706B5629711AE0 FOREIGN KEY (barang_id) REFERENCES barang (id)');
        $this->addSql('ALTER TABLE produksi ADD CONSTRAINT FK_F8A645FD87C54E2 FOREIGN KEY (pesanan_id) REFERENCES pesanan (id)');
        $this->addSql('ALTER TABLE roles CHANGE description description VARCHAR(35) DEFAULT NULL');
        $this->addSql('ALTER TABLE staff CHANGE address address VARCHAR(35) DEFAULT NULL, CHANGE phone phone VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pengambilan DROP FOREIGN KEY FK_47B23C33D87C54E2');
        $this->addSql('ALTER TABLE pesanan DROP FOREIGN KEY FK_80706B5629711AE0');
        $this->addSql('ALTER TABLE produksi DROP FOREIGN KEY FK_F8A645FD87C54E2');
        $this->addSql('DROP TABLE pengambilan');
        $this->addSql('DROP TABLE pesanan');
        $this->addSql('DROP TABLE produksi');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE roles CHANGE description description VARCHAR(35) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE staff CHANGE address address VARCHAR(35) DEFAULT \'NULL\', CHANGE phone phone VARCHAR(15) DEFAULT \'NULL\'');
    }
}
