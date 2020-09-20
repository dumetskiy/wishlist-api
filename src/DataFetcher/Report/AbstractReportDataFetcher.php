<?php

declare(strict_types=1);

namespace App\DataFetcher\Report;

abstract class AbstractReportDataFetcher
{
    /**
     * @param int|null $batchSize
     *
     * @return array
     */
    public function fetch(int $batchSize = null): array
    {
        $batchSize = $batchSize ?? $this->getDefaultBatchSize();
        $reportData = [];
        $lastSelectedItemId = null;

        do {
            $batchData = $this->fetchBatchData($batchSize, $lastSelectedItemId);
            $reportData = array_merge($reportData, $batchData);

            if (count($batchData) < $batchSize) {
                return $reportData;
            }

            $lastSelectedItemData = end($batchData);
            $lastSelectedItemId = $this->getItemIdentifier($lastSelectedItemData);
        } while (true);
    }

    /**
     * @return int
     */
    protected abstract function getDefaultBatchSize(): int;

    /**
     * @param int $batchSize
     * @param int|null $lastItemId
     *
     * @return array
     */
    protected abstract function fetchBatchData(int $batchSize, int $lastItemId = null): array;

    /**
     * @param array $itemData
     *
     * @return int
     */
    protected abstract function getItemIdentifier(array $itemData): int;
}
