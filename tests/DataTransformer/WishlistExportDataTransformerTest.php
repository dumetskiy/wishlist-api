<?php

declare(strict_types=1);

namespace DataTransformer;

use App\DataTransformer\WishlistExportDataTransformer;
use App\DTO\WishlistExportDTO;
use App\Entity\Wishlist;
use App\Exception\InvalidArgumentTypeException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class WishlistExportDataTransformerTest extends TestCase
{
    private const DEFAULT_WISHLIST_NAME = 'wishlistName';
    private const DEFAULT_WISHLIST_OWNER_USERNAME = 'ownerUsername';
    private const DEFAULT_WISHLIST_ITEMS_COUNT = 10;

    /**
     * @var WishlistExportDataTransformer
     */
    private $testClass;

    public function setUp(): void
    {
        $this->testClass = new WishlistExportDataTransformer();
    }

    public function testSupportsTransformation(): void
    {
        $wishlistMock = $this->getWishlistMock();

        // Checking the supported data provided case
        $this->assertTrue($this->testClass->supportsTransformation(
            $wishlistMock,
            WishlistExportDTO::class
        ));

        // Checking invalid $data value passed
        $this->assertFalse($this->testClass->supportsTransformation(
            null,
            WishlistExportDTO::class
        ));

        // Checking invalid $data value passed
        $this->assertFalse($this->testClass->supportsTransformation(
            [],
            WishlistExportDTO::class
        ));

        // Checking invalid $data value passed
        $this->assertFalse($this->testClass->supportsTransformation(
            new class {},
            WishlistExportDTO::class
        ));

        // Checking invalid $to value passed
        $this->assertFalse($this->testClass->supportsTransformation(
            $wishlistMock,
            get_class(new class {})
        ));

        // Checking invalid $to value passed
        $this->assertFalse($this->testClass->supportsTransformation(
            $wishlistMock,
            ''
        ));
    }

    public function testTransform(): void
    {
        $wishlistExportDTOMock = $this->getWishlistExportDTOMock();

        // Checking the valid result case
        $resultWishlistExportDTO = $this->testClass->transform(
            $this->getWishlistMock(),
            WishlistExportDTO::class
        );

        $this->assertSame(
            $resultWishlistExportDTO->getItemsCount(),
            $wishlistExportDTOMock->getItemsCount()
        );

        $this->assertSame(
            $resultWishlistExportDTO->getOwnerUsername(),
            $wishlistExportDTOMock->getOwnerUsername()
        );

        $this->assertSame(
            $resultWishlistExportDTO->getWishlistTitle(),
            $wishlistExportDTOMock->getWishlistTitle()
        );

        // Checking invalid $object value passed
        $this->expectException(InvalidArgumentTypeException::class);

        $this->testClass->transform(
            null,
            WishlistExportDTO::class
        );

        // Checking invalid $object value passed
        $this->expectException(InvalidArgumentTypeException::class);

        $this->testClass->transform(
            new class {},
            WishlistExportDTO::class
        );
    }

    /**
     * @param string $name
     * @param string $ownerUsername
     * @param int $itemsCount
     *
     * @return Wishlist|MockObject
     */
    private function getWishlistMock(
        string $name = self::DEFAULT_WISHLIST_NAME,
        string $ownerUsername = self::DEFAULT_WISHLIST_OWNER_USERNAME,
        int $itemsCount = self::DEFAULT_WISHLIST_ITEMS_COUNT
    ): MockObject {
        $wishlistMock = $this->createMock(Wishlist::class);

        $wishlistMock
            ->method('getItemsCount')
            ->willReturn($itemsCount);
        $wishlistMock
            ->method('getOwnerUsername')
            ->willReturn($ownerUsername);
        $wishlistMock
            ->method('getName')
            ->willReturn($name);

        return $wishlistMock;
    }

    /**
     * @param string $wishlistTitle
     * @param string $ownerUsername
     * @param int $itemsCount
     *
     * @return WishlistExportDTO|MockObject
     */
    private function getWishlistExportDTOMock(
        string $wishlistTitle = self::DEFAULT_WISHLIST_NAME,
        string $ownerUsername = self::DEFAULT_WISHLIST_OWNER_USERNAME,
        int $itemsCount = self::DEFAULT_WISHLIST_ITEMS_COUNT
    ): MockObject {
        $wishlistExportDTOMock = $this->createMock(WishlistExportDTO::class);

        $wishlistExportDTOMock
            ->method('getItemsCount')
            ->willReturn($itemsCount);
        $wishlistExportDTOMock
            ->method('getOwnerUsername')
            ->willReturn($ownerUsername);
        $wishlistExportDTOMock
            ->method('getWishlistTitle')
            ->willReturn($wishlistTitle);

        return $wishlistExportDTOMock;
    }
}