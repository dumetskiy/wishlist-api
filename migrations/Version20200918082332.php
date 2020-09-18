<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918082332 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Adds Wishlist, Wishlist Items tables and mapping table to link wishlist and it\'s items';
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
                PRIMARY KEY(intWishlistId)) 
                DEFAULT CHARACTER SET utf8mb4 
                COLLATE `utf8mb4_unicode_ci` 
                ENGINE = InnoDB
            ');

        $this->addSql('
            CREATE TABLE tblWishlistItem (
                intWishlistItemId INT AUTO_INCREMENT NOT NULL, 
                intProductId INT DEFAULT NULL, 
                intWishlistId INT DEFAULT NULL, 
                dtmCreated DATETIME NOT NULL, 
                INDEX IDX_tblWishlistItem_intProductId (intProductId), 
                INDEX IDX_tblWishlistItem_intWishlistId (intWishlistId), 
                PRIMARY KEY(intWishlistItemId)
            ) 
            DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE tblWishlist 
            ADD CONSTRAINT FK_tblWL_intUserId_tblU_intUserId
            FOREIGN KEY (intUserId) 
            REFERENCES tblUser (intUserId) 
            ON DELETE CASCADE
        ');

        $this->addSql('
            ALTER TABLE tblWishlistItem 
            ADD CONSTRAINT FK_tblWLI_intProductId_tblP_intProductId
            FOREIGN KEY (intProductId) 
            REFERENCES tblProduct (intProductId) 
            ON DELETE CASCADE
        ');

        $this->addSql('
            ALTER TABLE tblWishlistItem 
            ADD CONSTRAINT FK_tblWLI_intWishlistId_tblWL_intWishlistId
            FOREIGN KEY (intWishlistId) 
            REFERENCES tblWishlist (intWishlistId) 
            ON DELETE CASCADE
        ');

        $this->addSql('DROP INDEX UNIQ_tblProduct_strName ON tblProduct');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_tblProduct_strName ON tblProduct (strName)');
        $this->addSql('DROP INDEX UNIQ_tblUser_strUsername ON tblUser');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('
            ALTER TABLE tblWishlistItem 
            DROP FOREIGN KEY FK_tblWLI_intWishlistId_tblWL_intWishlistId
        ');
        $this->addSql('DROP TABLE tblWishlist');
        $this->addSql('DROP TABLE tblWishlistItem');
        $this->addSql('DROP INDEX UNIQ_tblProduct_strName ON tblProduct');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_tblProduct_strName ON tblProduct (strName)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_tblUser_strUsername ON tblUser (strUsername)');
    }
}
