<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $userstatus = $this->getUser();
        if($userstatus){
            if($request->isXmlHttpRequest()){
                die(json_encode(true));
            }else{
                return $this->render('MainBundle:default:index.html.twig', array(
                    'user_logged_in' => true
                ));
            }
        }else{
            if($request->isXmlHttpRequest()){
                die(json_encode(false));
            }else{
                return $this->render('MainBundle:default:index.html.twig', array(
                    'user_logged_in'=> false
                ));
            }
        }
    }

}
