<?php

namespace PersonalAreaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;

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

    /**
     *
     * @Route("/personal_area/{action}", name="personal_area")
     *
     */
    public function findLostAction($action)
    {
        $userstatus = $this->getUser();
        if($userstatus){
            return $this->render('PersonalAreaBundle:default:index.html.twig');
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}
