<?php declare(strict_types=1);

namespace Project\Module\Ranking;

use Project\Module\GenericValueObject\Datetime;
use Project\Module\Team\Team;

/**
 * Class Ranking
 * @package     Project\Module\Ranking
 */
class Ranking
{
    /** @var int $ranking */
    protected $ranking;

    /** @var Team $team */
    protected $team;

    /** @var int $rounds */
    protected $rounds;

    /** @var Datetime */
    protected $lastTime;

    /**
     * Ranking constructor.
     *
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function getRanking(): int
    {
        return $this->ranking;
    }

    /**
     * @param int $ranking
     */
    public function setRanking(int $ranking): void
    {
        $this->ranking = $ranking;
    }

    /**
     * @return int
     */
    public function getRounds(): int
    {
        return $this->rounds;
    }

    /**
     * @param int $rounds
     */
    public function setRounds(int $rounds): void
    {
        $this->rounds = $rounds;
    }

    /**
     * @return Datetime
     */
    public function getLastTime(): Datetime
    {
        return $this->lastTime;
    }

    /**
     * @param Datetime $lastTime
     */
    public function setLastTime(Datetime $lastTime): void
    {
        $this->lastTime = $lastTime;
    }

    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }
}