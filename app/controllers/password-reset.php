<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;
use App\Helpers\MailerHelper;

class PasswordReset extends BaseController{

    var $title = "Evermore Timer | Password Reset";
    var $public = true;
    var $layout = "login";
    var $scripts = array(
        'login/login',
    );

    public function index(){
        $this->model = new \stdClass;
        $request = UserDataManager::get_password_request_by_id($this->action);
        if(isset($request["user_id"])){
            $this->model->request_id = $this->action;
        }else{
            $this->redirect(REAL_URL . "/invalid-request");
        }
    }
    
    public function update(){
        $this->model = new \stdClass;
        $this->model->request_id = $this->request_id;
        $request = UserDataManager::get_password_request_by_id($this->request_id);
        if(isset($request["user_id"])){
            if(empty($this->password) || empty($this->cpassword)){
                $this->model->error_message = "Please enter new password";
            }else{
                if($this->password == $this->cpassword){
                    UserDataManager::update_password($request["user_id"], $this->password, $this->request_id);
                    $this->redirect(REAL_URL . "/login");
                }else{
                    $this->model->error_message = "Password not matched";
                }
            }
        }else{
            $this->redirect(REAL_URL . "/invalid-request");
        }
    }

}