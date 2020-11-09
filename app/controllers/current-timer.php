<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\CurrentTimerDataManager;
use App\Components\Membership;

class CurrentTimer extends BaseController{
    
    var $scripts = array();
    var $layout = "none";
    public function index(){
        
    }
    
    public function delete(){
        TaskIntervalDataManager::delete_task_intervals_by_id($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function running(){
        //$date = new \DateTime();
        //die("==".date("Y-m-d H:i:s", 1599054557));
        $result = CurrentTimerDataManager::get_current_timer_by_user();
    }
    
    public function set(){
        //$test = new \Memcache();
        //$test->set("ct", "onin");
        $result = CurrentTimerDataManager::add_new_timer((object)$_POST);
        if(isset($result)){
            $result->time_now = time();    
        }
        $response = new \stdClass;
        $response->result = "success";
        $response->serverTimestamp = time();
        $response->data = $result;  
        $this->response_json($response);
    }
}