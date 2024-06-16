<?php

declare(strict_types=1);

namespace App\Command;

use App\Profile\AndroidVersionProfile;
use App\Profile\BaseProfile;
use App\Profile\BrowserProfile;
use App\Profile\IosVersionProfile;
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

    public function __construct(
        private readonly DataFileManager $dataFileManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void {}

    protected function execute(InputInterface $input, OutputInterface $output): int {
        /** @var array<BaseProfile> $profiles */
        $profiles = [new IosVersionProfile(), new AndroidVersionProfile(), new BrowserProfile()];
        $stepsCount = 0;
        foreach ($profiles as $profile) {
            $stepsCount += count($profile->subcategories) * self::OPERATIONS_PER_SUBCATEGORY;
        }

        $io = new SymfonyStyle(input: $input, output: $output);
        $progressBar = $io->createProgressBar($stepsCount);
        $cursor = new Cursor($output);
        $successStyle = 'success';
        $failureStyle = 'failure';
        $io->getFormatter()->setStyle($successStyle, new OutputFormatterStyle('green'));
        $io->getFormatter()->setStyle($failureStyle, new OutputFormatterStyle('red'));
        $tab = '    ';

        $fileDownloaded = false;
        foreach ($profiles as $profile) {
            foreach ($profile->subcategories as $subcategory) {
                $io->section("$profile->category - $subcategory");

                $io->text('UPDATE');
                self::outputBeforeOperation(progressBar: $progressBar, io: $io);
                if ($fileDownloaded) {
                    self::wait();
                }
                $updateResult = $this->dataFileManager->updateFile(profile: $profile, subcategory: $subcategory);
                self::outputAfterOperation(progressBar: $progressBar, cursor: $cursor);

                if ($updateResult instanceof DataFileResultDTO) {
                    $style = ($updateResult->status === DataFileResultDTO::STATUS_SUCCESS)
                        ? $successStyle
                        : $failureStyle
                    ;
                    $io->text("<$style>$updateResult->message</>");
                    $io->text("{$tab}File: $updateResult->filePath");
                    $io->text("{$tab}Url: $updateResult->fileUrl");
                    $fileDownloaded = true;
                } else {
                    $io->text('No file update required.');
                    $fileDownloaded = false;
                }
                $io->newLine();

                $io->text('DELETE');
                self::outputBeforeOperation(progressBar: $progressBar, io: $io);
                $deleteResults = $this->dataFileManager->deleteOldFiles(profile: $profile, subcategory: $subcategory);
                self::outputAfterOperation(progressBar: $progressBar, cursor: $cursor);

                foreach ($deleteResults as $index => $deleteResult) {
                    $number = $index + 1;
                    $style = ($deleteResult->status === DataFileResultDTO::STATUS_SUCCESS)
                        ? $successStyle
                        : $failureStyle
                    ;
                    $io->text("<$style>$number. $deleteResult->message</>");
                    $io->text("{$tab}File: $deleteResult->filePath");
                }
                if (count($deleteResults) === 0) {
                    $io->text('No file deletion required.');
                }

                $io->newLine();
            }
        }
        $progressBar->finish();
        $io->newLine();

        return Command::SUCCESS;
    }

    private static function outputBeforeOperation(ProgressBar $progressBar, SymfonyStyle $io): void {
        $io->newLine();
        $progressBar->display();
    }

    private static function outputAfterOperation(ProgressBar $progressBar, Cursor $cursor): void {
        $progressBar->advance();
        $progressBar->clear();
        $cursor->moveUp();
    }

    private static function wait(): void {
        sleep(rand(5, 10));
    }
}
