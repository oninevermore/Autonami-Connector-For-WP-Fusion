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
        $this->model->timer_invitations = $this->get_all_timer_invitations();
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
    
    private function get_all_timer_invitations(){
        $temp_array = array();
        $timer_invitations = TaskIntervalDataManager::get_all_timer_invitations();
        if(!empty($timer_invitations) && is_array($timer_invitations)){
            $i = 0;
            $key_array = array();
            foreach($timer_invitations as $val) {
                if (!isset($key_array[$val["email"]])) {
                    $key_array[$val["email"]] = true;
                    $temp_array[] = array(
                        "user_id" => $val["user_id"],
                        "email" => $val["email"],
                        "first_name" => $val["first_name"],
                        "last_name" => $val["last_name"],
                        "invitations" => $this->get_timer_invitations_by_user($timer_invitations, $val["email"])
                    );
                }
                $i++;
            }
        }
        return $temp_array;
    }
    
    public function remove_share(){
        TaskIntervalDataManager::unshare_task_intervals_by_id($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function cancel_invitation(){
        TaskIntervalDataManager::cancel_task_intervals_invitation_by_id($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function reject_invitation(){
        TaskIntervalDataManager::reject_task_invitation($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function approved_invitation(){
        $task_invitation = TaskIntervalDataManager::get_task_invitation_by_id($this->id);
        TaskIntervalDataManager::accept_task_invitation($this->id, $task_invitation["timer_ids"], $task_invitation["email"]);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    private function get_timer_invitations_by_user($timer_invitations, $email){
        $timers = array();
        foreach($timer_invitations as $val) {
            if($val["email"] == $email){
                $full_details = json_decode($val["task_intervals"]);
                $timers[] = array(
                    "status" => $val["status"],
                    "name" => $full_details->timer_set_name,
                    "share_id" => $val["share_id"]
                );
            }
        }
        return $timers;
    }
    
    private function get_shared_timer_users($shared_timers, $task_id){
        $users = array();
        foreach($shared_timers as $val) {
            if($val["id"] == $task_id){
                $users[] = array(
                    "status" => $val["status"],
                    "share_id" => $val["share_id"],
                    "first_name" => $val["first_name"],
                    "last_name" => $val["last_name"],
                    "email" => $val["email"]
                );
            }
        }
        return $users;
    }
}       