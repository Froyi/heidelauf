<?php declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\GenericValueObject\Id;
use Project\Module\Reader\ReaderService;
use Project\Module\Reader\RunService;
use Project\Module\Team\TeamService;
use Project\Utilities\Tools;
use Project\View\JsonModel;

/**
 * Class JsonController
 * @package     Project\Controller
 * @copyright   Copyright (c) 2018 Maik Schößler
 */
class JsonController extends DefaultController
{
    /** @var JsonModel $jsonModel */
    protected $jsonModel;

    /**
     * JsonController constructor.
     *
     * @param Configuration $configuration
     * @param string        $routeName
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        parent::__construct($configuration, $routeName);

        $this->jsonModel = new JsonModel();
    }

    public function editTeamAction()
    {
        try {
            $teamId = Id::fromString(Tools::getValue('teamId'));
        } catch (\Exception $exception) {
            $this->jsonModel->send('error');
            exit;
        }

        $teamService = new TeamService($this->database);
        $team = $teamService->getTeamByTeamId($teamId);

        if ($team === null) {
            $this->jsonModel->send('error');
        }

        $this->viewRenderer->addViewConfig('team', $team);

        try {
            $this->jsonModel->addJsonConfig('view',
                $this->viewRenderer->renderJsonView('module/partial/editTeams.twig'));
            $this->jsonModel->send();
        } catch (\Twig_Error_Loader | \Twig_Error_Runtime | \Twig_Error_Syntax $exception) {
            $this->jsonModel->send('error');
        }
    }

    public function refreshAction()
    {
        $readingService = new ReaderService($this->database);
        $runs = $readingService->readFile($this->transponderService->getTransponderCodes(), $this->configuration);

        if (\count($runs) > 0) {
            $readingService->saveRuns($runs);
        }
        $runService = new RunService($this->database);
        $donationSum = $runService->getDonationSum();

        $teamService = new TeamService($this->database);
        $teams = $teamService->getAllTeams($runService);

        $this->viewRenderer->addViewConfig('teams', $teams);

        try {
            $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('module/ranking.twig'));
            $this->jsonModel->addJsonConfig('donationSum', $donationSum);
            $this->jsonModel->send();
        } catch (\Twig_Error_Loader | \Twig_Error_Runtime | \Twig_Error_Syntax $exception) {
            $this->jsonModel->send('error');
        }
    }
}