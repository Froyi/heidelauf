<?php declare(strict_types=1);

namespace Project\Module\Reader;

use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\DatetimeInterface;
use Project\Module\GenericValueObject\Id;

/**
 * Class Run
 * @package     Project\Module\Reader
 */
class Run
{
    /** @var Id $runId */
    protected $runId;

    /** @var int $transponderNumber */
    protected $transponderNumber;

    /** @var Datetime $timestamp */
    protected $timestamp;

    /**
     * @return Id
     */
    public function getRunId(): Id
    {
        return $this->runId;
    }

    /**
     * @return int
     */
    public function getTransponderNumber(): int
    {
        return $this->transponderNumber;
    }

    /**
     * @return Datetime
     */
    public function getTimestamp(): Datetime
    {
        return $this->timestamp;
    }

    /**
     * Run constructor.
     *
     * @param Id                $runId
     * @param int               $transponderNumber
     * @param DatetimeInterface $timestamp
     */
    public function __construct(Id $runId, int $transponderNumber, DatetimeInterface $timestamp)
    {
        $this->runId = $runId;
        $this->transponderNumber = $transponderNumber;
        $this->timestamp = $timestamp;
    }
}