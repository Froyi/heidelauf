<?php declare(strict_types=1);

namespace Project\Module\Team;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class TeamRepository
 * @package     Project\Module\Team
 */
class TeamRepository
{
    /** @var string TABLE */
    protected const TABLE = 'team';

    /** @var string ORDERBY_TEAMNAME */
    protected const ORDERBY_TEAMNAME = 'teamName';

    /** @var Database */
    protected $database;

    /**
     * TeamRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param Id $teamId
     *
     * @return mixed
     */
    public function getTeamByTeamId(Id $teamId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('teamId', '=', $teamId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param int $transponderNumber
     *
     * @param Id  $teamId
     *
     * @return mixed
     */
    public function getTeamByTransponderNumber(int $transponderNumber, Id $teamId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('transponderNumber', '=', $transponderNumber);
        $query->andWhere('teamId','!=', $teamId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @return array
     */
    public function getAllTeams(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->orderBy(self::ORDERBY_TEAMNAME, Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function saveTeam(Team $team): bool
    {
        if ($this->getTeamByTeamId($team->getTeamId()) === false) {
            $query = $this->database->getNewInsertQuery(self::TABLE);
            $query->insert('teamId', $team->getTeamId()->toString());
            $query->insert('teamName', $team->getTeamName());
            $query->insert('transponderNumber', $team->getTransponderNumber());
            $query->insert('extreme', $team->isExtreme());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewUpdateQuery(self::TABLE);
        $query->set('teamId', $team->getTeamId()->toString());
        $query->set('teamName', $team->getTeamName());
        $query->set('transponderNumber', $team->getTransponderNumber());
        $query->set('extreme', $team->isExtreme());

        $query->where('teamId', '=', $team->getTeamId()->toString());

        return $this->database->execute($query);
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function deleteTeam(Team $team): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('teamId', '=', $team->getTeamId()->toString());

        return $this->database->execute($query);
    }
}