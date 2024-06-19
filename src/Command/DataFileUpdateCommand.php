<?php

declare(strict_types=1);

namespace App\Command;

use App\Profile\AndroidVersionProfile;
use App\Profile\BaseProfile;
use App\Profile\BrowserProfile;
use App\Profile\IosVersionProfile;
use App\Profile\OsProfile;
use App\Profile\PlatformProfile;
use App\Profile\SearchEngineProfile;
use App\Profile\WindowsVersionProfile;
use App\Service\DataFileManager;
use App\Service\DataFileResultDTO;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// php bin/console app:data-file-update
#[AsCommand(name: 'app:data-file-update')]
class DataFileUpdateCommand extends Command
{
    private const int OPERATIONS_PER_SUBCATEGORY = 2;

    private SymfonyStyle $io;
    private Cursor $cursor;
    private ProgressBar $progressBar;

    private string $successStyle = 'success';
    private string $failureStyle = 'failure';

    private bool $fileDownloadedStatus = false;

    public function __construct(
        private readonly DataFileManager $dataFileManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $this->io = new SymfonyStyle(input: $input, output: $output);
        $this->cursor = new Cursor($output);
        $this->progressBar = $this->io->createProgressBar();

        /** @var array<BaseProfile> $profiles */
        $profiles = [
            new AndroidVersionProfile(),
            new BrowserProfile(),
            new IosVersionProfile(),
            new OsProfile(),
            new PlatformProfile(),
            new SearchEngineProfile(),
            new WindowsVersionProfile(),
        ];
        $stepsCount = self::getSpetsCount(profiles: $profiles);

        $this->progressBar->setMaxSteps($stepsCount);
        $this->successStyle = 'success';
        $this->failureStyle = 'failure';
        $this->io->getFormatter()->setStyle($this->successStyle, new OutputFormatterStyle('green'));
        $this->io->getFormatter()->setStyle($this->failureStyle, new OutputFormatterStyle('red'));

        foreach ($profiles as $profile) {
            foreach ($profile->subcategories as $subcategory) {
                $this->io->section("$profile->category - $subcategory");
                $this->cursor->moveUp();

                $this->io->text('UPDATE');
                $this->updateFile(profile: $profile, subcategory: $subcategory);

                $this->io->text('DELETE');
                $this->deleteOldFiles(profile: $profile, subcategory: $subcategory);

                $this->io->newLine();
            }
        }
        $this->progressBar->finish();
        $this->io->newLine();

        return Command::SUCCESS;
    }

    private function updateFile(BaseProfile $profile, string $subcategory): void {
        $this->outputBeforeOperation();
        $this->waitBeforeFileDownload();
        $updateResult = $this->dataFileManager->updateFile(profile: $profile, subcategory: $subcategory);

        $this->outputAfterOperation();
        if ($updateResult instanceof DataFileResultDTO) {
            $style = ($updateResult->status === DataFileResultDTO::STATUS_SUCCESS)
                ? $this->successStyle
                : $this->failureStyle
            ;
            $this->io->text("<$style>$updateResult->message</>");
            $this->io->text("    File: $updateResult->filePath");
            $this->io->text("    Url: $updateResult->fileUrl");
            $this->fileDownloadedStatus = true;
        } else {
            $this->io->text('No file update required.');
            $this->fileDownloadedStatus = false;
        }
    }

    private function deleteOldFiles(BaseProfile $profile, string $subcategory): void {
        $this->outputBeforeOperation();
        $deleteResults = $this->dataFileManager->deleteOldFiles(profile: $profile, subcategory: $subcategory);
        $this->outputAfterOperation();

        foreach ($deleteResults as $index => $deleteResult) {
            $number = $index + 1;
            $style = ($deleteResult->status === DataFileResultDTO::STATUS_SUCCESS)
                ? $this->successStyle
                : $this->failureStyle
            ;
            $this->io->text("<$style>$number. $deleteResult->message</>");
            $this->io->text("    File: $deleteResult->filePath");
        }
        if (count($deleteResults) === 0) {
            $this->io->text('No file deletion required.');
        }
    }

    private function outputBeforeOperation(): void {
        $this->io->newLine();
        $this->progressBar->display();
    }

    private function outputAfterOperation(): void {
        $this->progressBar->advance();
        $this->progressBar->clear();
        $this->cursor->moveUp();
    }

    private function waitBeforeFileDownload(): void {
        if ($this->fileDownloadedStatus) {
            sleep(rand(5, 10));
        }
    }

    /**
     * @param array<BaseProfile> $profiles
     */
    private static function getSpetsCount(array $profiles): int {
        $stepsCount = 0;
        foreach ($profiles as $profile) {
            $stepsCount += count($profile->subcategories) * self::OPERATIONS_PER_SUBCATEGORY;
        }

        return $stepsCount;
    }
}
