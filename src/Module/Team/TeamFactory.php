<?php declare(strict_types=1);

namespace Project\Module\Team;

use Project\Module\GenericValueObject\Id;

/**
 * Class TeamFactory
 * @package     Project\Module\Team
 */
class TeamFactory
{
    /**
     * @param $object
     *
     * @return null|Team
     * @throws \InvalidArgumentException
     */
    public function getTeamByObject($object): ?Team
    {
        if (empty($object->teamId) === true) {
            return null;
        }
        $teamId = Id::fromString($object->teamId);

        if (empty($object->teamName) === true) {
            return null;
        }
        $teamName = $object->teamName;

        if (isset($object->extreme) === false) {
            return null;
        }
        $extreme = (bool)$object->extreme;

        if (empty($object->transponderNumber) === true) {
            return null;
        }
        $transponderNumber = (int)$object->transponderNumber;

        return new Team($teamId, $teamName, $extreme, $transponderNumber);
    }
}