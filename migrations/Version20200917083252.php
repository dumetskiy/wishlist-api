<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200917083252 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create wishlist entity and link it to user and product';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE tblWishlist (
                intWishlistId INT AUTO_INCREMENT NOT NULL, 
                strName VARCHAR(30) NOT NULL, 
                intUserId INT DEFAULT NULL,
                INDEX IDX_tblWishlist_intUserId (intUserId), 
                PRIMARY KEY(intWishlistId)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE tblWishlistProduct (
                intWishlistId INT NOT NULL, 
                intProductId INT NOT NULL, 
                INDEX IDX_tblWishlistProduct_intWishlistId (intWishlistId), 
                INDEX IDX_tblWishlistProduct_intProductId (intProductId), 
                PRIMARY KEY(intWishlistId, intProductId)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ');
        $this->addSql('
            ALTER TABLE tblWishlist 
            ADD CONSTRAINT FK_tblWishlist_intUserId_tblUser_intUserId
            FOREIGN KEY (intUserId) 
            REFERENCES tblUser (intUserId) 
            ON DELETE SET NULL
        ');
        $this->addSql('
            ALTER TABLE tblWishlistProduct 
            ADD CONSTRAINT FK_tblWP_intWishlistId_tblWL_intWishlistId
            FOREIGN KEY (intWishlistId) 
            REFERENCES tblWishlist (intWishlistId) 
            ON DELETE CASCADE
        ');
        $this->addSql('
            ALTER TABLE tblWishlistProduct 
            ADD CONSTRAINT FK_tblWP_intProductId_tblP_intProductId 
            FOREIGN KEY (intProductId) 
            REFERENCES tblProduct (intProductId) 
            ON DELETE CASCADE
        ');
        $this->addSql('DROP INDEX idx_tblproduct_strname ON tblProduct');
        $this->addSql('CREATE UNIQUE INDEX IDX_tblProduct_strName ON tblProduct (strName)');
        $this->addSql('DROP INDEX idx_tbluser_strusername ON tblUser');
        $this->addSql('CREATE UNIQUE INDEX IDX_tblUser_strUsername ON tblUser (strUsername)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE tblWishlistProduct 
            DROP FOREIGN KEY tblWP_intWishlistId_tblWL_intWishlistId
        ');
        $this->addSql('DROP TABLE tblWishlist');
        $this->addSql('DROP TABLE tblWishlistProduct');
        $this->addSql('DROP INDEX IDX_tblProduct_strName ON tblProduct');
        $this->addSql('CREATE UNIQUE INDEX IDX_tblProduct_strName ON tblProduct (strName)');
        $this->addSql('DROP INDEX IDX_tblUser_strUsername ON tblUser');
        $this->addSql('CREATE UNIQUE INDEX idx_tbluser_strusername ON tblUser (strUsername)');
    }
}
