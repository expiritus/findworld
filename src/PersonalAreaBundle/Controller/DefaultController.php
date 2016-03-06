<?php

namespace PersonalAreaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     *
     * @Route("/personal_area/{action}", name="personal_area")
     *
     */
    public function indexAction($action)
    {
        $userstatus = $this->getUser();
        if($userstatus){
            return $this->render('PersonalAreaBundle:Default:index.html.twig');
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        }

    }
}
