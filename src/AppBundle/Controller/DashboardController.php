<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProjectType;
use AppBundle\Service\RedmineRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    private $redmineRequestService;

    public function __construct(RedmineRequestService $redmineRequestService)
    {
        $this->redmineRequestService = $redmineRequestService;
    }

    /**
     * @Route("/dashboard", name="dashboard")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('dashboard/index.html.twig');
    }

    /**
     * Method displays projects list from Redmine.
     *
     * @Route("/dashboard/projects", name="projects")
     */
    public function showProjectsAction()
    {
        $data = $this->redmineRequestService->getProjects();

        $projectForm = $this->createForm(ProjectType::class);
        return $this->render('dashboard/projects/projects.html.twig', [
            'project' => $projectForm->createView(),
            'projects' => $data['projects']
        ]);
    }

    /**
     * Method displays projects details from Redmine.
     *
     * @Route("/dashboard/projects/{projectId}", requirements={"projectId" = "\d+"}, name="project_details")
     */
    public function showProjectDetailsAction(Request $request, $projectId)
    {
        $projectDetails = $this->redmineRequestService->getProjectDetails($projectId);
        $issues = $this->redmineRequestService->getIssuesByProjectId($projectId);

        return $this->render('dashboard/projects/project.html.twig', [
            'details' => $projectDetails,
            'issues' => $issues['issues']
        ]);
    }
}
