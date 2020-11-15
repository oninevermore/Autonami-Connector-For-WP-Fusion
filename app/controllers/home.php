<?php

namespace App\Controllers;
use App\Components\Membership;
use App\DataManager\TaskIntervalDataManager;
use App\DataManager\CurrentTimerDataManager;
use App\DataManager\UserDataManager;
use App\Core\BaseController;
use App\Helpers\TimeHelper;
use App\Helpers\TaskHelper;

class Home extends BaseController{

    var $title = "Homepage";
    var $scripts = array("vendors/NoSleep.min", "dashboard", "task", "manage-account");

    public function index(){
        $this->model = new \stdClass;
        $this->model->task_details = TaskHelper::get_task_intervals_by_user_id();
        $current_timer = TaskHelper::get_current_timer();
        $this->model->current_timer = $current_timer["current_timer"];
        $this->model->timer_details = $current_timer["timer_details"];
        $this->model->users = $this->get_all_users();
    } 
    
    private function get_all_users(){
        $result = UserDataManager::get_all_user();
        $data = array();
        if(is_array($result) && sizeof($result) > 0){
            $current_email = Membership::current_user()->email;
            foreach($result as $item){
                if($item["email"] != $current_email){
                    $n_item = new \stdClass;
                    $n_item->value = $item["first_name"] . " " . $item["last_name"];
                    $n_item->email = $item["email"];
                    $n_item->initials = substr(ucfirst($item["first_name"]), 1, 1)  . substr(ucfirst($item["first_name"]), 1, 1);
                    $n_item->initialsState = "";
                    $n_item->pic = "";
                    $data[] = $n_item;
                }
            }
        }
        return json_encode($data);
    }
    
    public function running(){
        $result = CurrentTimerDataManager::get_current_timer_by_user();
        $current_timer = null;
        if(is_array($result) && sizeof($result) > 0){
            foreach($result as $item){
                $item = (object)$item;
                if($item->user_id == Membership::current_user()->id){
                    $current_timer = (object)$item;
                    $current_timer->time_now = time();
                }
            }
            $current_timer = (object)$result[0];
            $current_timer->time_now = time();
        }
        $response = new \stdClass;
        $response->result = "success";
        $response->current_timer = $current_timer; 
        $this->response_json($response);
    }
    
}       