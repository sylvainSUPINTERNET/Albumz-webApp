<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{






    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            //User is connected (More than Anonymous)

            var_dump($this->getUser()->getRoles());
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            ]);
        }else{
            //User not connected
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
