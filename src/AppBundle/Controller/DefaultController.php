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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $message = '';

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
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }
}
