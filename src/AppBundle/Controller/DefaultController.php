<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\PhotoType;
use Symfony\Component\Form\Form;


// uplodad
//  ->add('devisFile', 'file')
// display <a href="{{ vich_uploader_asset(devis, 'devisFile') }}" />Voir mon devis</a>


class DefaultController extends Controller
{


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        if ($this->getUserConnected()) {
            var_dump($this->getUserRoles());
        }

        $photo = new Photo();
        $formUploadPic = $this->createForm(PhotoType::class, $photo);

        $formUploadPic->handleRequest($request);

        if ($formUploadPic->isSubmitted() && $formUploadPic->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dataPosted = $formUploadPic->getData();
            $photo->setName($dataPosted->getName());
            $photo->setPhotoFile($dataPosted->getPhotoFile());




            $em->persist($photo);



            //nom du fichier image avec extension
            //var_dump($dataPosted->getName());
            //$uri = $this->convertToUri($dataPosted->getName());
            //$photo->setUri($uri);


            $em->flush();




            /*
            return $this->redirect($this->generateUrl(
                'admin_post_show',
                array('id' => $post->getId())
            ));
            */
        }


        return $this->render('AppBundle:Home:index.html.twig', array(
                "testForm" => $formUploadPic->createView(),
            )
        );
    }


    //UTILS method
    public function getUserConnected()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->getUser();
        } else {
            return false;
        }
    }

    public function getUserRoles()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->getUser()->getRoles();
        } else {
            return false;
        }
    }


    /*
    public function convertToUri($imageFileName){

        $mainDir = getcwd(); //dir web ..
        $dir = $mainDir.'\uploads\photos\\';
        $image = $dir.$imageFileName;


        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
        var_dump($dataUri);
        return $dataUri;
    }
    */
}
