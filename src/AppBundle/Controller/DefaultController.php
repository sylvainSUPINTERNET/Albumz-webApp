<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DefaultController extends Controller
{


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {



        if($this->getUserConnected()){
            var_dump($this->getUserRoles());
        }



        return $this->render('AppBundle:Home:index.html.twig', array()
        );
    }




    //UTILS method
    public function getUserConnected(){
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->getUser();
        }else{
            return false;
        }
    }

    public function getUserRoles(){
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->getUser()->getRoles();
        }else{
            return false;
        }
    }
}
