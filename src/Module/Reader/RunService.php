<?php declare(strict_types=1);

namespace Project\Module\Reader;

use Project\Module\Database\Database;

/**
 * Class RunService
 * @package     Project\Module\Reader
 */
class RunService
{
    /** @var RunRepository $runRepository */
    protected $runRepository;

    /** @var RunFactory $runFactory */
    protected $runFactory;

    /**
     * RunService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->runRepository = new RunRepository($database);
        $this->runFactory = new RunFactory();
    }

    public function getRunsByTransponderNumber(int $transponderNumber): array
    {
        $runsArray = [];

        $runsData = $this->runRepository->getRunsByTransponderNumber($transponderNumber);

        foreach ($runsData as $runData) {
            $run = $this->runFactory->getRunFromObject($runData);

            if ($run !== null) {
                $runsArray[] = $run;
            }
        }

        return $runsArray;
    }

    public function getDonationSum()
    {
        return (int)$this->runRepository->countRuns();
    }
}