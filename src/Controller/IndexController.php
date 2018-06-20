<?php
declare (strict_types=1);

namespace Project\Controller;


use Project\Module\GenericValueObject\Datetime;

use Project\Module\GenericValueObject\Id;
use Project\Module\Reader\RunService;
use Project\Module\Team\Team;
use Project\Module\Team\TeamService;
use Project\Utilities\Tools;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    public function indexAction(): void
    {
        $runService = new RunService($this->database);
        $donationSum = $runService->getDonationSum();

        $teamService = new TeamService($this->database);
        $teams = $teamService->getAllTeams($runService);

        $startingTime = Datetime::fromValue($this->configuration->getEntryByName('startingTime'));
        $started = $startingTime->isPastDatetime();

        $this->viewRenderer->addViewConfig('teams', $teams);
        $this->viewRenderer->addViewConfig('donationSum', $donationSum);
        $this->viewRenderer->addViewConfig('started', $started);
        $this->viewRenderer->addViewConfig('page', 'home');
        $this->viewRenderer->renderTemplate();
    }

    public function testAction(): void
    {
        $runService = new RunService($this->database);
        $teamService = new TeamService($this->database);
        $teams = $teamService->getAllTeams($runService);

        $rounds = [];

        /** @var Team $team */
        foreach ($teams as $team) {
            $rounds[] = $team->getFastestRound();
        }
        var_dump($rounds);
    }

    public function finishAction(): void
    {
        $runService = new RunService($this->database);
        $teamService = new TeamService($this->database);
        $teams = $teamService->getAllTeams($runService);

        $this->viewRenderer->addViewConfig('teams', $teams);
        $this->viewRenderer->addViewConfig('page', 'finish');
        $this->viewRenderer->renderTemplate();
    }

    public function adminAction(): void
    {
        $runService = new RunService($this->database);
        $teamService = new TeamService($this->database);
        $teams = $teamService->getAllTeams($runService);


        $this->viewRenderer->addViewConfig('teams', $teams);
        $this->viewRenderer->addViewConfig('page', 'admin');
        $this->viewRenderer->renderTemplate();
    }

    public function insertTeamAction(): void
    {
        $teamService = new TeamService($this->database);
        try {
            $team = $teamService->getTeamByParameter($_POST);
        } catch (\Exception $exception) {
            $team = null;
        }

        if ($team === null) {
            $this->notificationService->setError('Konnte nicht gespeichert werden.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }

        if ($teamService->getTeamByTransponderNumber($team->getTransponderNumber(), $team->getTeamId()) !== null) {
            $this->notificationService->setError('Konnte nicht gespeichert werden. Die Transpondernummer ist schon vergeben.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }
        if ($teamService->saveTeamToRepository($team) === true) {
            $this->notificationService->setSuccess('Das Team wurde erfolgreich gespeichert.');
        } else {
            $this->notificationService->setError('Das Team konnte nicht gespeichert werden.');
        }

        header('Location: ' . Tools::getRouteUrl('admin'));
    }

    public function deleteTeamAction(): void
    {
        try {
            $teamId = Id::fromString(Tools::getValue('teamId'));
        } catch (\Exception $exception) {
            $this->notificationService->setError('Das Team konnte nicht gefunden werden. Es wurden nicht alle Daten übergeben.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }

        $teamService = new TeamService($this->database);
        $team = $teamService->getTeamByTeamId($teamId);

        if ($team === null) {
            $this->notificationService->setError('Das Team konnte nicht gefunden werden. Es wurde kein Team gefunden.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }

        if ($teamService->deleteTeam($team) === true) {
            $this->notificationService->setSuccess('Das Team wurde erfolgreich gelöscht.');
        } else {
            $this->notificationService->setError('Das Team konnte nicht gelöscht werden.');
        }

        header('Location: ' . Tools::getRouteUrl('admin'));
    }

    public function editTeamSubmitAction(): void
    {
        $teamService = new TeamService($this->database);
        try {
            $team = $teamService->getTeamByParameter($_POST);
        } catch (\Exception $exception) {
            $team = null;
        }

        if ($team === null) {
            $this->notificationService->setError('Konnte nicht bearbeitet werden.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }

        if ($teamService->getTeamByTransponderNumber($team->getTransponderNumber(), $team->getTeamId()) !== null) {
            $this->notificationService->setError('Konnte nicht bearbeitet werden. Die Transpondernummer ist schon vergeben.');

            header('Location: ' . Tools::getRouteUrl('admin'));
            exit;
        }
        if ($teamService->saveTeamToRepository($team) === true) {
            $this->notificationService->setSuccess('Das Team wurde erfolgreich bearbeitet.');
        } else {
            $this->notificationService->setError('Das Team konnte nicht bearbeitet werden.');
        }

        header('Location: ' . Tools::getRouteUrl('admin'));
    }
}