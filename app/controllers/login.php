<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;

class Login extends BaseController{

    var $title = "Evermore Timer | Login Page";
    var $public = true;
    var $layout = "login";
    var $scripts = array(
        'login/login',
    );

    public function index(){
        $this->model = new \stdClass;
        $redirect = filter_input(INPUT_GET, "redirect");
        $this->model->redirect = $redirect;
    }

    public function add_new_user(){
        $response = new  \stdClass;
        if(!UserDataManager::is_email_exists($this->email)){
            $result = UserDataManager::add_new_user($this);
            if($result == null){
                $response->result = "success";
            }else{
                $response->result = "failed";
                $response->error_message = "Failed adding new account";
            }
        }else{
            $response->result = "failed";
            $response->error_message = "Email address was already registered. Please try other email";
        }
        
        $this->response_json($response);
    }

    public function logged_in(){
        $response = new \stdClass;
        if(UserDataManager::is_valid_credential($this->email, $this->password)){
            $user = UserDataManager::get_user($this->email, $this->password);
            Membership::authenticate((object)$user);
            $response->result = "success";
            $response->return_url = REAL_URL . $this->redirect;
        }else{
            $response->result = "failed";
            $response->error_message = "Invalid email or password";
        }
        
        $this->response_json($response);
    }
}