<?php declare(strict_types=1);

namespace Project\Module\Reader;

use Project\Configuration;
use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Datetime;


/**
 * Class ReaderService
 * @package     Project\Module\Reader
 */
class ReaderService
{
    /** @var RunRepository $runRepository */
    protected $runRepository;

    /**
     * ReaderService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->runRepository = new RunRepository($database);
    }

    /**
     * @param array $transponderTranslation
     *
     * @return array
     */
    public function readFile(array $transponderTranslation, Configuration $configuration): array
    {
        $runArray = [];
        $runFactory = new RunFactory();
        $file = file('192.168.1.8.txt');
        $count = \count($file);
        $endTime = Datetime::fromValue($configuration->getEntryByName('endTime'));
        $startTime = Datetime::fromValue($configuration->getEntryByName('startingTime'));

        for ($i = 0; $i < $count; $i++) {
            $fileData = explode('	', $file[$i]);

            $run = $runFactory->createRunFromFileData($transponderTranslation[$fileData[0]], $fileData[1]);
            if ($run->getTimestamp()->getDifference($startTime) > 0 && $run->getTimestamp()->getDifference($endTime) < 0) {
                $runArray[] = $run;
            }
        }

        return $runArray;
    }

    public function saveRuns(array $runs): bool
    {
        if ($this->runRepository->deleteRuns() === false) {
            return false;
        }

        foreach ($runs as $run) {
            if ($this->runRepository->saveRun($run) === false) {
                return false;
            }
        }

        return true;
    }
}