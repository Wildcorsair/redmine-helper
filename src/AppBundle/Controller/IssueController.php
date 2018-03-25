<?php

namespace AppBundle\Controller;

use AppBundle\Form\TimeLogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\RedmineRequestService;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends Controller
{
    /**
     * @var RedmineRequestService
     */
    private $redmineRequestService;

    /**
     * IssueController constructor.
     *
     * @param RedmineRequestService $redmineRequestService
     */
    public function __construct(RedmineRequestService $redmineRequestService)
    {
        $this->redmineRequestService = $redmineRequestService;
    }

    /**
     * @Route("/dashboard/issues", name="issues")
     */
    public function showIssuesAction()
    {
        //TODO: list of issues
    }

    /**
     * @Route("/dashboard/issues/{issueId}", requirements={"issueId" = "\d+"}, name="issue_details")
     *
     * @param int $issueId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showIssueDetailsAction($issueId)
    {
//        $this->redmineRequestService->setIssueTime($issueId);

        $details = $this->redmineRequestService->getIssueDetails($issueId);

        return $this->render('dashboard/issues/issue.html.twig', [
            'issue' => $details
        ]);
    }

    /**
     * @Route("/dashboard/issues/{issueId}/time-log", requirements={"issueId" = "\d+"}, name="time_log")
     */
    public function showTimeLogFormAction(Request $request, $issueId)
    {
        $timeLog = $this->createForm(TimeLogType::class, ['issue_id' => $issueId]);

        $timeLog->handleRequest($request);

        if ($timeLog->isSubmitted() && $timeLog->isValid()) {

            $timeLogData = $timeLog->getData();

            dump($timeLogData['date']->format('Y-m-d'));
            $result = $this->redmineRequestService->setIssueTime($timeLogData);
//            dump($result);

//            return $this->redirectToRoute('task_success');
        }

        return $this->render('dashboard/issues/time-log.html.twig', [
            'time_log' => $timeLog->createView(),
            'issue_id' => $issueId
        ]);
    }
}
