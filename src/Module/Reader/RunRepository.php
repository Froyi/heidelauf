<?php declare(strict_types=1);

namespace Project\Module\Reader;

use Project\Module\Database\Database;
use Project\Module\Database\Query;

/**
 * Class RunRepository
 * @package     Project\Module\Reader
 */
class RunRepository
{
    protected const TABLE = 'run';

    protected const ORDER_BY = 'timestamp';

    /** @var Database */
    protected $database;

    /**
     * RunRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param Run $run
     *
     * @return bool
     */
    public function saveRun(Run $run): bool
    {

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('runId', $run->getRunId()->toString());
        $query->insert('transponderNumber', $run->getTransponderNumber());
        $query->insert('timestamp', $run->getTimestamp()->toString());

        return $this->database->execute($query);
    }

    /**
     * @return bool
     */
    public function deleteRuns(): bool
    {
        $query = $this->database->getNewTruncatQuery(self::TABLE);

        return $this->database->execute($query);
    }

    /**
     * @param int $transponderNumber
     *
     * @return array
     */
    public function getRunsByTransponderNumber(int $transponderNumber): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('transponderNumber', '=', $transponderNumber);
        $query->orderBy(self::ORDER_BY, Query::DESC);

        return $this->database->fetchAll($query);
    }

    public function countRuns()
    {
        $query = $this->database->getNewCountQuery(self::TABLE);

        $count = $this->database->fetch($query);

        return current($count);
    }
}