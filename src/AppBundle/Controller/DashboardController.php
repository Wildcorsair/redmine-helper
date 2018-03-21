<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function indexAction()
    {
        $project = $this->createForm(ProjectType::class);
        return $this->render('dashboard/index.html.twig', [
            'project' => $project->createView()
        ]);
    }
}
