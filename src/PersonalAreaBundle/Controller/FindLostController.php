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
        if(empty($thing)){
            $thing = htmlspecialchars($request->request->get('custom_thing'));
        }


        $action = ucfirst($action);
        $find_lost_entity = '\AdminBundle\Entity\\'.$action;
        $find_lost_obj = new $find_lost_entity;
        $em = $this->getDoctrine()->getManager();

        $country = $em->getRepository('AdminBundle:Country')->find($country_id);
        $find_lost_obj->setCountry($country);

        $city = $em->getRepository('AdminBundle:City')->find($city_id);
        $find_lost_obj->setCity($city);

        if($area_name){
            $entity_name = 'Area';
            $parent_id = array('cityId' => $city_id);
            $parent_associated_obj = array('city' => $city);
            $area = $this->checkData($area_name, $parent_id, $parent_associated_obj, $em, $entity_name);
            $find_lost_obj->setArea($area);
            $area_id = $area->getId();
        }

        if($street_name){
            $entity_name = 'Street';
            $parent_id = array('cityId' => $city_id, 'areaId' => $area_id);
            $parent_associated_obj = array('city' => $city, 'area' => $area);
            $street = $this->checkData($street_name, $parent_id, $parent_associated_obj, $em, $entity_name);
            $find_lost_obj->setStreet($street);
        }

        if($thing){
            $entity_name = 'Thing';
            $thing = $this->checkData($thing, null, null, $em, $entity_name);
            $find_lost_obj->setThing($thing);
        }


        $user = $this->getUser();
        $find_lost_obj->setUserName($user);

        $em->persist($find_lost_obj);
        $em->flush();
    }

    private function checkData($data_name, array $parent_id = null, array $parent_associated_obj = null, $em, $entity_name){
        $repository = 'AdminBundle:'.$entity_name;
        $column = strtolower($entity_name);
        if(count($parent_id) == 1){
            $check_isset_obj = $em->getRepository($repository)->findOneBy(array(
                $column => $data_name,
                key($parent_id) => $parent_id['cityId']
            ));
        }elseif(count($parent_id) == 2) {
            $check_isset_obj = $em->getRepository($repository)->getStreetByParent($data_name, $parent_id);
        }elseif($parent_id == null){
            if($data_name){
                $check_isset_obj = $em->getRepository($repository)->findOneBy(array(
                    'id' => $data_name
                ));
            }else{
                $check_isset_obj = $em->getRepository($repository)->findOneBy(array(
                    $column => $data_name
                ));
            }

        }else{
            $check_isset_obj = $em->getRepository($repository)->findOneBy(array(
                $column => $data_name
            ));
        }

        if(!$check_isset_obj){
            $entity_obj = '\AdminBundle\Entity\\'.$entity_name;
            $entity = new $entity_obj;
            switch ($entity_name){
                case 'Area':
                    $data_name = trim($this->mb_ucfirst($data_name, "UTF-8"));
                    $data_name .= ' р-н';
                    $entity->setArea($data_name);
                    $entity->setCity($parent_associated_obj['city']);
                    break;
                case 'Street':
                    $entity->setStreet($data_name);
                    $entity->setCity($parent_associated_obj['city']);
                    $entity->setArea($parent_associated_obj['area']);
                    break;
                case 'Thing':
                    $entity->setThing($data_name);
                    $entity->setBaseThing(0);
                    break;
            }

            $em->persist($entity);
            $em->flush();
            return $entity;
        }else{
            return $check_isset_obj;
        }
    }

    private function mb_ucfirst($string, $encoding){
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
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
}