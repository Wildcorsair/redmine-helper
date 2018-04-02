<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\RedmineRequestService;

class ProjectController extends Controller
{
    /**
     * @var RedmineRequestService
     */
    private $redmineRequestService;

    public function __construct(RedmineRequestService $redmineRequestService)
    {
        $this->redmineRequestService = $redmineRequestService;
    }

    /**
     * Method displays projects list from Redmine.
     *
     * @Route("/dashboard/projects", name="projects")
     */
    public function showProjectsAction()
    {
        $data = $this->redmineRequestService->getProjects();

        return $this->render('dashboard/projects/projects.html.twig', [
            'projects' => $data['projects']
        ]);
    }

    /**
     * Method displays projects details from Redmine.
     *
     * @Route("/dashboard/projects/{projectId}", requirements={"projectId" = "\d+"}, name="project_details")
     */
    public function showProjectDetailsAction($projectId)
    {
        $projectDetails = $this->redmineRequestService->getProjectDetails($projectId);
        $issues = $this->redmineRequestService->getIssuesByProjectId($projectId);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(
            ['projectId' => $projectId],
            ['createdAt' => 'DESC'],
            3
        );

        return $this->render('dashboard/projects/project.html.twig', [
            'details' => $projectDetails,
            'issues' => $issues,
            'comments' => $comments
        ]);
    }
}
