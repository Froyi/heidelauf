<?php declare(strict_types=1);

namespace Project\Module\Team;

use Project\Module\DefaultModel;
use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\DatetimeInterface;
use Project\Module\GenericValueObject\Id;
use Project\Module\Reader\Run;

/**
 * Class Team
 * @package     Project\Module\Team
 */
class Team extends DefaultModel
{
    /** @var Id $teamId */
    protected $teamId;

    /** @var string $teamName */
    protected $teamName;

    /** @var bool $extreme */
    protected $extreme;

    /** @var int $transponderNumber */
    protected $transponderNumber;

    /** @var array $runArray */
    protected $runArray = [];

    /**
     * @return Id
     */
    public function getTeamId(): Id
    {
        return $this->teamId;
    }

    /**
     * @return string
     */
    public function getTeamName(): string
    {
        return $this->teamName;
    }

    /**
     * @return bool
     */
    public function isExtreme(): bool
    {
        return $this->extreme;
    }

    /**
     * @return int
     */
    public function getTransponderNumber(): int
    {
        return $this->transponderNumber;
    }

    /**
     * @param array $runArray
     */
    public function setRunArray(array $runArray): void
    {
        $this->runArray = $runArray;
    }

    /**
     * @return array
     */
    public function getRuns(): array
    {
        return $this->runArray;
    }

    public function getRounds(): int
    {
        return \count($this->runArray);
    }

    public function getLastRound()
    {
        if (empty($this->runArray) === true) {
            return null;
        }

        /** @var Run $firstRun */
        $firstRun = $this->runArray[0];

        /** @var Run $secondRun */
        $secondRun = null;
        if (empty($this->runArray[1]) === false) {
            $secondRun = $this->runArray[1];
        }

        if ($secondRun === null) {
            $secondRun = Datetime::fromValue($this->configuration->getEntryByName('startingTime'));
        } else {
            $secondRun = $secondRun->getTimestamp();
        }

        return $firstRun->getTimestamp()->getDifference($secondRun);
    }

    public function getFastestRound()
    {
        $fastestRound = [];
        $rounds = $this->getRoundTimes();

        if (empty($rounds) === true) {
            return null;
        }

        $fastestRoundKey = array_search(min($rounds), $rounds);

        if (empty($fastestRoundKey) === true) {
            return null;
        }

        $fastestRound[$fastestRoundKey] = $rounds[$fastestRoundKey];
        return $fastestRound;
    }

    public function getRoundTimes()
    {
        $roundDiffs = [];

        if (empty($this->runArray) === true) {
            return null;
        }

        $lastRun = null;
        foreach ($this->runArray as $run) {
            if ($lastRun === null) {
                $lastRun = $run;
                continue;
            }

            $roundDiffs[] = $lastRun->getTimestamp()->getDifference($run->getTimeStamp());
        }

        if ($lastRun !== null) {
            $run = Datetime::fromValue($this->configuration->getEntryByName('startingTime'));
            $roundDiffs[] = $lastRun->getTimestamp()->getDifference($run);
        }
        return array_reverse($roundDiffs);
    }

    /**
     * @return DatetimeInterface
     */
    public function getLastTimestamp(): ?DatetimeInterface
    {
        if (empty($this->runArray) === true) {
            return null;
        }

        /** @var Run $firstRun */
        $firstRun = current($this->runArray);

        return $firstRun->getTimestamp();
    }

    /**
     * Team constructor.
     *
     * @param Id     $teamId
     * @param string $teamName
     * @param bool   $extreme
     * @param int    $transponderNumber
     */
    public function __construct(Id $teamId, string $teamName, bool $extreme, int $transponderNumber)
    {
        parent::__construct();

        $this->teamId = $teamId;
        $this->teamName = $teamName;
        $this->extreme = $extreme;
        $this->transponderNumber = $transponderNumber;
    }
}