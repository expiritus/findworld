<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 27.3.16
 * Time: 21.19
 */

namespace PersonalAreaBundle\Controller;


use AdminBundle\Entity\Area;
use AdminBundle\Entity\Lost;
use AdminBundle\Entity\Find;
use AdminBundle\Entity\Street;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\TemplateNameParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FindLostController extends Controller
{

    /**
     *
     * @Route("/personal_area/{action}", name="personal_area")
     *
     */
    public function findLostAction(Request $request, $action)
    {
        if($request->isMethod('POST')){
            $this->saveData($request, $action);
            return $this->redirectToRoute('personal_area', array('action' => $action));
        }

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


    private function saveData(Request $request, $action){
        $country_id = (int)htmlspecialchars($request->request->get('country'));
        $city_id = htmlspecialchars($request->request->get('city'));
        $area_name = htmlspecialchars($request->request->get('area'));
        $street_name = htmlspecialchars($request->request->get('street'));
        $thing = htmlspecialchars($request->request->get('thing'));
        $custom_thing = htmlspecialchars($request->request->get('custom_thing'));

        $action = ucfirst($action);
        $find_lost_entity = '\AdminBundle\Entity\\'.$action;
        $find_lost_obj = new $find_lost_entity;
        $em = $this->getDoctrine()->getManager();

        $country = $em->getRepository('AdminBundle:Country')->find($country_id);
        $find_lost_obj->setCountry($country);

        $city = $em->getRepository('AdminBundle:City')->find($city_id);
        $find_lost_obj->setCity($city);

        if($area_name){
            //проверяем есть ли название района в базе данных
            $check_isset_area = $em->getRepository('AdminBundle:Area')->findOneBy(array(
                'area' => $area_name,
                'cityId' => $city_id
            ));

            if(!$check_isset_area){
                $area_name = $this->mb_ucfirst($area_name, "UTF-8");
                $area_name .= ' р-н';

                $area = new Area();
                $area->setArea($area_name);
                $area->setCity($city);
                $em->persist($area);
                $em->flush();
                $find_lost_obj->setArea($area);
            }else{
                $find_lost_obj->setArea($check_isset_area);
            }
        }

        $check_isset_street = $em->getRepository('AdminBundle:Street')->findOneBy(array(
            'street' => $street_name,
            'cityId' => $city_id
        ));

        if(!$check_isset_street){
            $street_name = $this->mb_ucfirst($street_name, 'UTF-8');
            $street_name .= ' ул.';

            $street = new Street();
            $street->setStreet($street_name);
            $street->setCity($city);
            if($check_isset_area){
                $street->setArea($check_isset_area);
            }else{
                $street->setArea($area);
            }

            $em->persist($street);
            $em->flush();
            $find_lost_obj->setStreet($street);
        }else{
            $find_lost_obj->setStreet($check_isset_street);
        }

        $em->persist($find_lost_obj);
        $em->flush();
    }


    /**
     *
     * @Route("/get_city/{country_id}", name="get_city")
     *
     * */
    public function getCity($country_id){
        $country_id = htmlspecialchars($country_id);
        $repository = $this->getDoctrine()->getRepository('AdminBundle:City');
        $cities = $repository->getCityByCountryId($country_id);
        $response = new Response(json_encode($cities));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
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
        $areas = $repository->getAreaByCityId($city_id);
        $response = new Response(json_encode($areas));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

    /**
     *
     * @Route("/get_street", name="get_street")
     *
     * */
    public function getStreet(Request $request){
        //название района и id города из формы
        $city_id = htmlspecialchars($request->query->get('city_id'));
        $area_name = htmlspecialchars($request->query->get('area_name'));

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AdminBundle:Street');

        if($area_name){
            $area = $em->getRepository('AdminBundle:Area')->findOneBy(array(
                'area' => $area_name
            ));
            $area_id = $area->getId();
            $streets = $repository->getStreetByAreaId($area_id);
        }else{
            $streets = $repository->getStreetByCityId($city_id);
        }

        $response = new Response(json_encode($streets));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }


    /**
     *
     * @Route("/get_thing", name="get_thing")
     *
     *
     * */
    public function getThing(Request $request){
        $things = $this->getDoctrine()->getRepository('AdminBundle:Thing')->getBaseThings();

        $response = new Response(json_encode($things));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }



    private function mb_ucfirst($string, $encoding){
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }



}