<?php declare(strict_types=1);

namespace Project\Module\Reader;

use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\DatetimeInterface;
use Project\Module\GenericValueObject\Id;

/**
 * Class RunFactory
 * @package     Project\Module\Reader
 */
class RunFactory
{
    /**
     * @param $transponderNumber
     * @param $timestamp
     *
     * @return null|Run
     */
    public function createRunFromFileData($transponderNumber, $timestamp): ?Run
    {
        $runId = Id::generateId();
        $transponderNumber = (int)$transponderNumber;
        /** @var DatetimeInterface $timestamp */
        $timestamp = Datetime::fromValue($timestamp);

        return new Run($runId, $transponderNumber, $timestamp);
    }


    /**
     * @param $object
     *
     * @return null|Run
     */
    public function getRunFromObject($object): ?Run
    {
        $runId = Id::fromString($object->runId);
        $transponderNumber = (int)$object->transponderNumber;
        /** @var DatetimeInterface $timestamp */
        $timestamp = Datetime::fromValue($object->timestamp);

        return new Run($runId, $transponderNumber, $timestamp);
    }
}