<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\RedmineRequestService;

class IssueController extends Controller
{
    private $redmineRequestService;

    public function __construct(RedmineRequestService $redmineRequestService)
    {
        $this->redmineRequestService = $redmineRequestService;
    }

    /**
     * @Route("/dashboard/issue/{issueId}", requirements={"issueId" = "\d+"}, name="issue_details")
     *
     * @param int $issueId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function issueDetailsAction($issueId)
    {
        $this->redmineRequestService->setIssueTime($issueId);

        $details = $this->redmineRequestService->getIssueDetails($issueId);

        return $this->render('dashboard/issues/issue.html.twig', [
            'issue' => $details
        ]);
    }
}
