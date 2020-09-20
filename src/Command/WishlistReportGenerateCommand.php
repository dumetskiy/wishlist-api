<?php

declare(strict_types=1);

namespace App\Command;

use App\DataFetcher\Report\WishlistReportDataFetcher;
use App\DataFormatter\CsvDataFormatter;
use App\FileSystem\Report\ReportDataSaver;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Filesystem\Exception\IOException;

class WishlistReportGenerateCommand extends BaseCommand
{
    private const ARGUMENT_OUTPUT_FILENAME = 'file';
    private const OPTION_FORCE = 'force';
    private const OPTION_FORCE_SHORTCUT = 'f';
    private const DEFAULT_REPORT_FILENAME_TEMPLATE = 'wishlist_report_%s.csv';
    private const COMMAND_NAME = 'app:wishlist-report-generate';

    /**
     * @var WishlistReportDataFetcher
     */
    private $reportDataFetcher;

    /**
     * @var ReportDataSaver
     */
    private $reportDataSaver;

    /**
     * @var CsvDataFormatter
     */
    private $csvDataFormatter;

    /**
     * @param WishlistReportDataFetcher $reportDataFetcher
     * @param ReportDataSaver $reportDataSaver
     * @param CsvDataFormatter $csvDataFormatter
     */
    public function __construct(
        WishlistReportDataFetcher $reportDataFetcher,
        ReportDataSaver $reportDataSaver,
        CsvDataFormatter $csvDataFormatter
    ) {
        $this->reportDataFetcher = $reportDataFetcher;
        $this->reportDataSaver = $reportDataSaver;
        $this->csvDataFormatter = $csvDataFormatter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Generates a wishlist report and saves it to the file')
            ->addArgument(
                self::ARGUMENT_OUTPUT_FILENAME,
                InputArgument::OPTIONAL,
                'A path to the file to save a report to',
                $this->getDefaultFilename()
            )
            ->addOption(
                self::OPTION_FORCE,
                self::OPTION_FORCE_SHORTCUT,
                InputOption::VALUE_OPTIONAL,
                'Force command execution with no confirmation',
                false
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln($this->getInfoMessage('Wishlist report generation tool started'));

            $reportFileName = $input->getArgument(self::ARGUMENT_OUTPUT_FILENAME);
            $reportFullFilePath = $this->reportDataSaver->getFullReportFilePath($reportFileName);

            if (null !== $input->getOption(self::OPTION_FORCE)) {
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion($this->getQuestionMessage(sprintf(
                    'Report will be saved to: "%s", are you okay with that? (yes/no) ', $reportFullFilePath
                )), false);

                if (!$helper->ask($input, $output, $question)) {
                    return self::SUCCESS;
                }
            }

            $output->writeln($this->getInfoMessage('Creating report file...'));
            $this->reportDataSaver->createReportFile($reportFileName);

            $output->writeln($this->getInfoMessage('Fetching report data...'));
            $reportData = $this->reportDataFetcher->fetch();

            $output->writeln($this->getInfoMessage('Serializing report data...'));
            $serializedReportData = $this->csvDataFormatter->formatData($reportData);

            $output->writeln($this->getInfoMessage('Saving report...'));
            $this->reportDataSaver->saveReport($reportFileName, $serializedReportData);

            return self::SUCCESS;
        } catch (\InvalidArgumentException $exception) {
            $output->writeln($this->getErrorMessage('Filesystem error occurred.'));

            return self::FAILURE;
        } catch (IOException $exception) {
            $output->writeln($this->getErrorMessage('Filesystem error occurred.'));

            return self::FAILURE;
        } catch (\Throwable $throwable) {
            $output->writeln($this->getErrorMessage('Unexpected error occurred.'));

            return self::FAILURE;
        }
    }

    /**
     * @return string
     */
    private function getDefaultFilename(): string
    {
        return sprintf(self::DEFAULT_REPORT_FILENAME_TEMPLATE, (new \DateTime())->format('y_m_d_h_i_s'));
    }
}
