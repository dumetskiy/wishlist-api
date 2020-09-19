<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200917082513 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create User table';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE tblUser (
                intUserId INT AUTO_INCREMENT NOT NULL, 
                strApiKey VARCHAR(50) NOT NULL, 
                strUsername VARCHAR(20) NOT NULL, 
                UNIQUE INDEX IDX_tblUser_strUsername (strUsername), 
                UNIQUE INDEX IDX_tblUser_strApiKey (strApiKey),
                PRIMARY KEY(intUserId)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tblUser');
    }
}
