<?php

namespace PersonalAreaBundle\Controller;

use AdminBundle\Entity\Lost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     *
     * @Route("/personal_area/{action}", name="personal_area")
     *
     */
    public function findLostAction(Request $request, $action)
    {
//        if($request->isMethod('Post')){
//            $this->saveData($request, $action);
//        }

        $userstatus = $this->getUser();
        if($userstatus){
            $repository = $this->getDoctrine()->getRepository('AdminBundle:Country');
            $countries = $repository->findAll();
            return $this->render('PersonalAreaBundle:default:find-lost.html.twig', array(
                'countries' => $countries,
                'action' => $action
            ));
        }else{
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    /**
     *
     * @Route("/get_city/{country_id}", name="get_city")
     *
     * */
    public function getCity($country_id){
        $country_id = htmlspecialchars($country_id);
        $repository = $this->getDoctrine()->getRepository('AdminBundle:City');
        $cities = $repository->getAllByParentId($country_id);
        $response = new Response(json_encode($cities));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     *
     * @Route("/get_area/{city_id}", name="get_area")
     *
     * */
    public function getArea($city_id){
        $city_id = htmlspecialchars($city_id);
        $repository = $this->getDoctrine()->getRepository('AdminBundle:Area');
        $areas = $repository->getAllByParentId($city_id);
        $response = new Response(json_encode($areas));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     *
     * @Route("/get_street", name="get_street")
     *
     * */
    public function getStreet(Request $request){
        $area_name = htmlspecialchars($request->request->get('area_name'));
        $city_id = htmlspecialchars($request->request->get('city_id'));
        $response = new Response(json_encode(array('area_name' => $area_name, 'city_id' => $city_id)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

//
//    private function saveData(Request $request, $action){
//        $country = htmlspecialchars($request->request->get('country'));
//        $city = htmlspecialchars($request->request->get('city'));
//        $area = htmlspecialchars($request->request->get('area'));
//        $street = htmlspecialchars($request->request->get('street'));
//        $action = ucfirst($action);
//        $find_lost_entity = '\AdminBundle\Entity\\'.$action;
//        $find_lost_data = new Lost();
//        $find_lost_data->setCountryId($country);
//        $find_lost_data->setCityId($city);
//        $find_lost_data->setThingId(1);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($find_lost_data);
//        $em->flush();
//    }

}
