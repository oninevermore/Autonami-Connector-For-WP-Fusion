<?php

namespace App\Controllers;
use App\Components\Membership;
use App\DataManager\UserDataManager;
use App\DataManager\TaskIntervalDataManager;
use App\Core\BaseController;

class ManageAccount extends BaseController{

    var $scripts = array();
    var $layout = "none";

    public function index(){
        $this->model = new \stdClass;
        $this->model->user = Membership::current_user();
        $this->model->shared_timers = $this->get_all_shared_timers();
    } 
    
    public function save(){
        $response = new \stdClass;
        $this->user_id = Membership::current_user()->id;
        $result = UserDataManager::save_user($this);
        if(empty($result)){
            Membership::update_info($this);
            $response->result = "success";
            $response->success_message = "Your account info was saved successfully.";
        }else{
            $response->result = "failed";
            $response->error_message = "Your account info was not saved successfully.";
        }
        $this->response_json($response);
    }
    
    public function change_password(){
        $response = new \stdClass;
        if(empty($this->password) || empty($this->cpassword)){
            $response->result = "failed";
            $response->error_message = "Please enter new password.";
        }else{
            if($this->password == $this->cpassword){
                UserDataManager::update_password(Membership::current_user()->id, $this->password);
                $response->result = "success";
                $response->success_message = "Password updated successfully.";
            }else{
                $response->result = "failed";
                $response->error_message = "Password not matched.";
            }
        }
        $this->response_json($response);
    }
    
    private function get_all_shared_timers(){
        $temp_array = array();
        $shared_timers = TaskIntervalDataManager::get_all_shared_tasks();
        if(!empty($shared_timers) && is_array($shared_timers)){
            $i = 0;
            $key_array = array();
            foreach($shared_timers as $val) {
                if (!isset($key_array[$val["id"]])) {
                    $key_array[$val["id"]] = true;
                    $full_details = json_decode($val["task_intervals"]);
                    $temp_array[] = array(
                        "id" => $val["id"],
                        "name" => $full_details->timer_set_name,
                        "users" => $this->get_shared_timer_users($shared_timers, $val["id"])
                    );
                }
                $i++;
            }
        }
        return $temp_array;
    }
    private function get_shared_timer_users($shared_timers, $task_id){
        $users = array();
        foreach($shared_timers as $val) {
            if($val["id"] == $task_id){
                $users[] = array(
                    "user_id" => $val["user_id"],
                    "first_name" => $val["first_name"],
                    "last_name" => $val["last_name"],
                    "email" => $val["email"]
                );
            }
        }
        return $users;
    }
}       