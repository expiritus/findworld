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

        //есил был указан район то выводим улицы относящиеся к этому району
        //иначе вывыодим все улицы относящиеся к id города
        if($area_name){

            //проверяем есть ли название района в базе данных
            $check_isset_area = $em->getRepository('AdminBundle:Area')->getAreaByName($area_name);

            //если нет то вносим название района в базу
            //если название районе есть в базе то выбираем все улицы с id ройона
            if(!$check_isset_area){
                $area = new Area();
                $area->setArea($area_name);
                $city = $em->getRepository('AdminBundle:City')->find($city_id);
                $area->setCity($city);
                $em->persist($area);
                $em->flush();
                $area_id = $area->getId();
                $streets = $repository->getStreetByAreaId($area_id);
            }else{
                $area = $em->getRepository('AdminBundle:Area')->findOneBy(array(
                    'area' => $area_name
                ));

                $area_id = $area->getId();
                $streets = $repository->getStreetByAreaId($area_id);
            }
        }else{
            $streets = $repository->getStreetByCityId($city_id);
        }



        $response = new Response(json_encode($streets));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
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