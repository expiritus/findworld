<?php

namespace PersonalAreaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Templating\TemplateNameParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     *
     * @Route("/personal_area", name="personal_area_index")
     *
     */
    public function indexAction()
    {
        $userstatus = $this->getUser();
        if($userstatus){
            return $this->render('PersonalAreaBundle:default:index.html.twig');
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
