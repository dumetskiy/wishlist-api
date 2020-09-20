<?php

declare(strict_types=1);

namespace App\DataFetcher\Report;

use App\Entity\Wishlist;
use Doctrine\ORM\EntityManagerInterface;

class WishlistReportDataFetcher extends AbstractReportDataFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return int
     */
    protected function getDefaultBatchSize(): int
    {
        return 100;
    }

    /**
     * @param int $batchSize
     * @param int|null $lastItemId
     *
     * @return array
     */
    protected function fetchBatchData(int $batchSize, int $lastItemId = null): array
    {
        return $this
            ->entityManager
            ->getRepository(Wishlist::class)
            ->fetchReportBatchData($batchSize, $lastItemId);
    }

    /**
     * @param array $itemData
     *
     * @return int
     */
    protected function getItemIdentifier(array $itemData): int
    {
        return $itemData['id'];
    }
}
