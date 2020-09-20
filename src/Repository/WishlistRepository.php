<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class WishlistRepository extends EntityRepository
{
    /**
     * @param int $batchSize
     * @param int|null $latestItemId
     *
     * @return array
     */
    public function fetchReportBatchData(int $batchSize, int $latestItemId = null): array
    {
        $queryBuilder = $this->createQueryBuilder('wishlist');
        $expressionBuilder = $queryBuilder->expr();

        $queryBuilder
            ->select(
                'wishlist.name AS wishlistName',
                'user.username AS ownerUsername',
                'COUNT(wishlistItems) AS itemsCount'
            )
            ->leftJoin('wishlist.user', 'user')
            ->leftJoin('wishlist.wishlistItems', 'wishlistItems')
            ->setMaxResults($batchSize)
            ->groupBy('wishlist.id');

        if (null !== $latestItemId) {
            $queryBuilder
                ->where($expressionBuilder->gt('wishlist.id', ':latestItemId'))
                ->setParameter('latestItemId', $latestItemId);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
