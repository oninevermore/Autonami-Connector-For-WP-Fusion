<?php

namespace App\Controllers;
use App\Components\Membership;
use App\DataManager\UserDataManager;
use App\Core\BaseController;

class ManageAccount extends BaseController{

    var $scripts = array();
    var $layout = "none";

    public function index(){
        $this->model = Membership::current_user();
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
    
}       