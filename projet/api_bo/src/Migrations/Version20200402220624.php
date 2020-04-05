<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402220624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, syndic_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, number INT NOT NULL, city VARCHAR(255) NOT NULL, complement VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(10) NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_E16F61D4F0654A02 (syndic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delegation (id INT AUTO_INCREMENT NOT NULL, meeting_id INT DEFAULT NULL, donor_owner_id INT DEFAULT NULL, receiver_owner_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_292F436D67433D9C (meeting_id), INDEX IDX_292F436D2B4FCEE4 (donor_owner_id), INDEX IDX_292F436D46999A0C (receiver_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, building_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_B81291B7E3C61F9 (owner_id), INDEX IDX_B81291B4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, date DATETIME NOT NULL, file_name VARCHAR(255) NOT NULL, guest_link VARCHAR(255) NOT NULL, live SMALLINT NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_F515E1394D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meeting_owner (meeting_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_A751A47C67433D9C (meeting_id), INDEX IDX_A751A47C7E3C61F9 (owner_id), PRIMARY KEY(meeting_id, owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, tantieme NUMERIC(4, 1) NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_CF60E67C4D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resolution (id INT AUTO_INCREMENT NOT NULL, meeting_id INT DEFAULT NULL, type_vote ENUM(\'Simple\', \'Absolue\', \'Double\', \'Unanimité\'), title VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_FDD30F8A67433D9C (meeting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE syndic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, syndic_id INT DEFAULT NULL, role VARCHAR(30) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, verification_id VARCHAR(255) DEFAULT NULL, verified SMALLINT DEFAULT NULL, hash VARCHAR(255) DEFAULT NULL, uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6497E3C61F9 (owner_id), UNIQUE INDEX UNIQ_8D93D649F0654A02 (syndic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, resolution_id INT DEFAULT NULL, result ENUM(\'Pour\', \'Contre\', \'Neutre\'), uuid VARCHAR(255) NOT NULL, INDEX IDX_5A1085647E3C61F9 (owner_id), INDEX IDX_5A10856412A1C43A (resolution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4F0654A02 FOREIGN KEY (syndic_id) REFERENCES syndic (id)');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D2B4FCEE4 FOREIGN KEY (donor_owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D46999A0C FOREIGN KEY (receiver_owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E1394D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE meeting_owner ADD CONSTRAINT FK_A751A47C67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meeting_owner ADD CONSTRAINT FK_A751A47C7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owner ADD CONSTRAINT FK_CF60E67C4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE resolution ADD CONSTRAINT FK_FDD30F8A67433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F0654A02 FOREIGN KEY (syndic_id) REFERENCES syndic (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085647E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856412A1C43A FOREIGN KEY (resolution_id) REFERENCES resolution (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B4D2A7E12');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E1394D2A7E12');
        $this->addSql('ALTER TABLE owner DROP FOREIGN KEY FK_CF60E67C4D2A7E12');
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D67433D9C');
        $this->addSql('ALTER TABLE meeting_owner DROP FOREIGN KEY FK_A751A47C67433D9C');
        $this->addSql('ALTER TABLE resolution DROP FOREIGN KEY FK_FDD30F8A67433D9C');
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D2B4FCEE4');
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D46999A0C');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B7E3C61F9');
        $this->addSql('ALTER TABLE meeting_owner DROP FOREIGN KEY FK_A751A47C7E3C61F9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497E3C61F9');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085647E3C61F9');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856412A1C43A');
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4F0654A02');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F0654A02');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE delegation');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE meeting_owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE resolution');
        $this->addSql('DROP TABLE syndic');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE refresh_tokens');
    }
}
