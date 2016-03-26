<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $userstatus = $this->getUser();
        if($userstatus){
            return $this->render('MainBundle:default:index.html.twig', array(
                'user_logged_in' => true
            ));
        }else{
            return $this->render('MainBundle:default:index.html.twig', array(
                'user_logged_in'=> false
            ));
        }
    }

}
