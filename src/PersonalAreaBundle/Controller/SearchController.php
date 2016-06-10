<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 9.6.16
 * Time: 22.42
 */

namespace PersonalAreaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Templating\TemplateNameParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
    private $desired_thing_data;
    private $all_find_lost_things;
    private $match_things = array();


    public function __construct($desired_thing_data, $all_find_lost_things){
        $this->desired_thing_data = $desired_thing_data;
        $this->all_find_lost_things = $all_find_lost_things;
    }




    public function search(){
        for($i=0; $i<count($this->all_find_lost_things); $i++){
            if(
                $this->all_find_lost_things[$i]['countryId'] == $this->desired_thing_data[0]['countryId'] and
                $this->all_find_lost_things[$i]['cityId'] == $this->desired_thing_data[0]['cityId'] and
                $this->all_find_lost_things[$i]['areaId'] == $this->desired_thing_data[0]['areaId'] and
                $this->all_find_lost_things[$i]['streetId'] == $this->desired_thing_data[0]['streetId'] and
                $this->all_find_lost_things[$i]['thingId'] == $this->desired_thing_data[0]['thingId']
            ){
                array_push($this->match_things, $this->all_find_lost_things[$i]['id']);
            }
        }
    }

    public function getIdsMatchThings(){
        return $this->match_things;
    }


}