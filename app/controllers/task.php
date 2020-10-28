<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\TaskIntervalDataManager;
use App\Components\Membership;
use App\Helpers\TaskHelper;

class Task extends BaseController{
    
    var $scripts = array();
    var $layout = "none";
    public function index(){
        $this->model = new \stdClass;
        $this->model->id = 0;
        $this->model->data = new \stdClass;
        $this->model->action =  REAL_URL ."/task/" . (isset($this->is_subtimer) &&  $this->is_subtimer == 1 ? "save_sub_tasks" : "save");
        $this->model->frm_name = (isset($this->is_subtimer) &&  $this->is_subtimer == 1 ? "frmSubTask" : "frmTask");
        $this->model->data->timer_set_name = "";
        $this->model->data->task_name = array();
        $this->model->timer_type = isset($_GET["timer_type"]) ? $_GET["timer_type"] : 0;
        $this->model->sub_timers = array();
        if(!empty($this->id)){
            if(isset($this->is_subtimer) && $this->is_subtimer == 1){
                $timer_set = TaskIntervalDataManager::get_sub_task_by_id($this->id);
            }else{
                $timer_set = TaskIntervalDataManager::get_task_intervals_by_id($this->id);
            }
            
            if(!empty($timer_set)){
                $data = json_decode($timer_set["task_intervals"]);
                $this->model->id = $timer_set["id"];
                $this->model->timer_type = isset($data->timer_type) ? $data->timer_type : 0;
                $this->model->data = $data;
                if($this->model->timer_type == 4){
                    $this->model->sub_timers = TaskHelper::get_sub_task_intervals_by_ids($data->sub_timers);
                }
            } 
        }
    }
    
    public function details(){
        $this->response_json(TaskHelper::get_task_details($this->id));
    }
    
    public function save(){
        $response = new \stdClass;
        $result = TaskIntervalDataManager::add_new_task_interval($_POST);
        if($result > 0){
            $response->result = "success";
        }else{
            $response->result = "failed";
            $response->error_message = "Failed adding new Task/Interval";
        }
        //$this->response_json($response);
        $this->redirect(REAL_URL);
    }
    
    public function save_sub_tasks(){
        $id =  TaskIntervalDataManager::add_new_sub_task_interval($_POST);
        $result = TaskHelper::get_sub_task_intervals_by_ids($id);
        $this->render_shared("sub-timer-list", $result);
    }
    
    public function delete(){
        TaskIntervalDataManager::delete_task_intervals_by_id($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function delete_sub_timer(){
        TaskIntervalDataManager::delete_sub_task_intervals_by_id($this->id);
        $response = new \stdClass;
        $response->result = "success";
        $this->response_json($response);
    }
    
    public function share(){
        $response = new \stdClass;
        if(isset($_POST["email_addresses"])){
            $email_addresses = json_decode($_POST["email_addresses"]);
            if(is_array($email_addresses)){
                $emails = array();
                foreach ($email_addresses as $value) {
                    $emails[] = isset($value->email) ? $value->email : $value->value;
                }
                
                $result = TaskIntervalDataManager::share_task_by_email($emails, $_POST["id"]);
            }
        }
        if($result > 0){
            $response->result = "success";
        }else{
            $response->result = "failed";
            $response->error_message = "Failed adding new Task/Interval";
        }
        //$this->response_json($response);
        $this->redirect(REAL_URL);
    }
    
    public function accept_timer_invitation(){
        $id = filter_input(INPUT_GET, "id");
        if(!empty($id)){
            $task_invitation = TaskIntervalDataManager::get_task_invitation_by_id($id);
            if($task_invitation["email"] == Membership::current_user()->email){
                   TaskIntervalDataManager::accept_task_invitation($id, $task_invitation["timer_ids"], $task_invitation["email"]);
                   $this->redirect(REAL_URL);
            }else{
                $this->redirect(REAL_URL . "/invalid-request");
            }
        }
            
    }
    
    public function duplicate(){
        TaskIntervalDataManager::duplicate_task_by_id($_POST["id"]);
        $data = TaskHelper::get_task_intervals_by_user_id();
        $this->render_shared("timer-list", $data);
    }
}