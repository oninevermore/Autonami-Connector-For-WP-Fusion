<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;
use App\Helpers\MailerHelper;
use App\Core\Vendor;

class Login extends BaseController{

    var $title = "Evermore Timer | Login Page";
    var $public = true;
    var $layout = "login";
    var $scripts = array(
        'login/login',
    );

    public function index(){
        Vendor::load("google");
        
        $client = new \Google_Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope("email");
        //$client->addScope("profile");
        
        $this->model = new \stdClass;
        $redirect = filter_input(INPUT_GET, "redirect");
        $this->model->redirect = $redirect;
        $this->model->google_auth_url = $client->createAuthUrl();
    }

    public function add_new_user(){
        $response = new  \stdClass;
        if(!UserDataManager::is_email_exists($this->email)){
            $result = UserDataManager::add_new_user($this);
            if($result > 0){
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
            $response->return_url = empty($this->redirect) ? REAL_URL : $this->redirect;
        }else{
            $response->result = "failed";
            $response->error_message = "Invalid email or password";
        }
        
        $this->response_json($response);
    }
    
    public function forgot_password_request(){
        $response = new \stdClass;
        $user = UserDataManager::get_user_by_email($this->email);
        if(isset($user["id"])){
            $request_id = UserDataManager::add_user_password_request($user["id"]);
            MailerHelper::send_forgot_password_email($this->email, $user["first_name"], $request_id);
            
            $response->result = "success";
            $response->success_message = "We have sent an email for password reset in your email address.";
        }else{
            $response->result = "failed";
            $response->error_message = "We're sorry, the user with that email address doesn't exist.";
        }
        $this->response_json($response);
    }
}