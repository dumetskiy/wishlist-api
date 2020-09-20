<?php

declare(strict_types=1);

namespace App\FileSystem\Report;

use Symfony\Component\Filesystem\Filesystem;

class ReportDataSaver
{
    private const REPORT_STORAGE_DIRECTORY = '/tmp/reports/';
    private const REPORT_PATH_TEMPLATE = '/tmp/reports/%s';

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->fileSystem = $filesystem;
    }

    /**
     * @param string $filename
     */
    public function createReportFile(string $filename): void
    {
        $this->prepareFileStructure();
        $this->fileSystem->touch($this->getFullReportFilePath($filename));
    }

    /**
     * @param string $filename
     * @param string $reportData
     */
    public function saveReport(string $filename, string $reportData): void
    {
        $this->fileSystem->appendToFile(
            $this->getFullReportFilePath($filename),
            $reportData
        );
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function getFullReportFilePath(string $filename): string
    {
        return sprintf(self::REPORT_PATH_TEMPLATE, $filename);
    }

    private function prepareFileStructure(): void
    {
        if (!$this->fileSystem->exists(self::REPORT_STORAGE_DIRECTORY)) {
            $this->fileSystem->mkdir(self::REPORT_STORAGE_DIRECTORY);
        }
    }
}
