<?php
/**
 * Created by PhpStorm.
 * User: michail
 * Date: 9.6.16
 * Time: 22.42
 */

namespace PersonalAreaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAware;

class SearchController extends Controller
{
    private $desired_thing_data;
    private $all_find_lost_things;


    public function __construct($desired_thing_data, $all_find_lost_things){
        $this->desired_thing_data = $desired_thing_data;
        $this->all_find_lost_things = $all_find_lost_things;
    }

    public function search(){

    }

}