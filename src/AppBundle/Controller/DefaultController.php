<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    /**
     * Default action for homepage route.
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $message = '';

        // If user is logged in redirect to the 'Dashboard'
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        // Else show Login form
        $login = $this->createForm(LoginType::class);
        $error = $authenticationUtils->getLastAuthenticationError();

        if (isset($error) && !empty($error)) {
            $message = $error->getMessage();
        }

        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render('default/index.html.twig', [
            'login'     => $login->createView(),
            '_username' => $lastUserName,
            'error'     => $message
        ]);
    }

    /**
     * Logout action.
     */
    public function logoutAction()
    {

    }
}
