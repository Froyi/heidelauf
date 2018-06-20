<?php declare(strict_types=1);
/**
 * TeamService.php
 *
 * @copyright   Copyright (c) 2018 CHECK24 Vergleichsportal Reisen GmbH München
 * @author      Maik Schößler <maik.schoessler@check24.de>
 * @since       12.06.2018
 */

namespace Project\Module\Team;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

use Project\Module\Reader\RunService;

/**
 * Class TeamService
 * @package     Project\Module\Team
 */
class TeamService
{
    /** @var TeamRepository $teamRepository */
    protected $teamRepository;

    /** @var TeamFactory $teamFactory */
    protected $teamFactory;

    /**
     * TeamService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->teamRepository = new TeamRepository($database);
        $this->teamFactory = new TeamFactory();
    }

    /**
     * @param Id $teamId
     *
     * @return null|Team
     */
    public function getTeamByTeamId(Id $teamId): ?Team
    {
        $teamData = $this->teamRepository->getTeamByTeamId($teamId);

        if (empty($teamData) === true) {
            return null;
        }

        return $this->teamFactory->getTeamByObject($teamData);
    }

    /**
     * @param $parameter
     *
     * @return null|Team
     */
    public function getTeamByParameter($parameter): ?Team
    {
        $object = (object)$parameter;

        if (isset($object->teamId) === false) {
            $object->teamId = Id::generateId()->toString();
        }

        if (isset($object->extreme) === true && $object->extreme === 'on') {
            $object->extreme = true;
        } else {
            $object->extreme = false;
        }

        return $this->teamFactory->getTeamByObject($object);
    }

    public function getTeamByTransponderNumber(int $transponderNumber, Id $teamId): ?Team
    {
        $teamData = $this->teamRepository->getTeamByTransponderNumber($transponderNumber, $teamId);

        if (empty($teamData) === true) {
            return null;
        }

        return $this->teamFactory->getTeamByObject($teamData);
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function saveTeamToRepository(Team $team): bool
    {
        return $this->teamRepository->saveTeam($team);
    }

    /**
     * @param RunService $runService
     *
     * @return array
     */
    public function getAllTeams(RunService $runService): array
    {
        $teamsArray = [];
        $array = [];
        $position = 1;
        $teamsData = $this->teamRepository->getAllTeams();

        if (empty($teamsData) === true) {
            return $teamsArray;
        }

        foreach ($teamsData as $teamData) {
            $team = $this->teamFactory->getTeamByObject($teamData);

            if ($team !== null) {
                $runs = $runService->getRunsByTransponderNumber($team->getTransponderNumber());

                $team->setRunArray($runs);

                $array[] = $team;
            }
        }

        $array = $this->sortTeams($array);

        /** @var Team $team */
        foreach ($array as $team) {
            $teamsArray[$position] = $team;
            $position ++;
        }

        return $teamsArray;
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function deleteTeam(Team $team): bool
    {
        return $this->teamRepository->deleteTeam($team);
    }

    /**
     * @param array $teamsArray
     *
     * @return array
     */
    protected function sortTeams(array $teamsArray): array
    {
        usort($teamsArray, [$this, 'cmp']);


        return $teamsArray;
    }

    public function cmp(Team $a, Team $b)
    {
        if ($a->getRounds() === $b->getRounds()) {
            if ($a->getLastTimestamp() === $b->getLastTimestamp()) {
                return 0;
            }
            return ($a->getLastTimestamp() < $b->getLastTimestamp()) ? -1 : 1;
        }

        return ($a->getRounds() > $b->getRounds()) ? -1 : 1;
    }
}