<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200917082804 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create product table';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE tblProduct (
                intProductId INT AUTO_INCREMENT NOT NULL, 
                strName VARCHAR(50) NOT NULL, 
                UNIQUE INDEX UNIQ_tblProduct_strName (strName), 
                PRIMARY KEY(intProductId)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ');

        $this->addSql('DROP INDEX IDX_tblUser_strUsername ON tblUser');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_tblUser_strUsername ON tblUser (strUsername)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tblProduct');
        $this->addSql('DROP INDEX UNIQ_tblUser_strUsername ON tblUser');
        $this->addSql('CREATE UNIQUE INDEX IDX_tblUser_strUsername ON tblUser (strUsername)');
    }
}
