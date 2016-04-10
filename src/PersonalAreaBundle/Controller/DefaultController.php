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
            $user_id = $this->getUser()->getId();
            $user_lost_things = $this->getDoctrine()->getRepository('AdminBundle:Lost')->findBy(array(
                'userId' => $user_id
            ));
            $user_find_things = $this->getDoctrine()->getRepository('AdminBundle:Find')->findBy(array(
                'userId' => $user_id
            ));
            return $this->render('PersonalAreaBundle:default:index.html.twig', array(
                'lost_things' => $user_lost_things,
                'find_things' => $user_find_things
            ));
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
