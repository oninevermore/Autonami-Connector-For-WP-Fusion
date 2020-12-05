<?php

namespace App\Controllers;

use \App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;
use App\Core\Vendor;

class Authorize extends BaseController{

    var $title = "Authorize";
    var $public = true;

    public function index(){
        if (isset($_GET["code"])) {
            Vendor::load("google");
            //It will Attempt to exchange a code for an valid authentication token.
            $google_client = new \Google_Client();
            $google_client->setClientId(GOOGLE_CLIENT_ID);
            $google_client->setClientSecret(GOOGLE_CLIENT_SECRET);
            $google_client->setRedirectUri(GOOGLE_REDIRECT_URI);
            $google_client->addScope("email");
            $google_client->addScope("profile");
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
            if (!isset($token['error'])) {
                //Set the access token used for requests
                $google_client->setAccessToken($token['access_token']);

                //Store "access_token" value in $_SESSION variable for future use.
                $_SESSION['access_token'] = $token['access_token'];

                //Create Object of Google Service OAuth 2 class
                $google_service = new \Google_Service_Oauth2($google_client);

                //Get user profile data from google
                $data = $google_service->userinfo->get();
                
                $this->verify_user($data);
                $this->redirect(REAL_URL);
            }
        }
    }
    
    private function verify_user($data){
        if(UserDataManager::is_email_exists($data['email'])){
            $user = UserDataManager::get_user_by_email($data['email']);
            Membership::authenticate((object)$user);
        }else{
            $user = new \stdClass;
            $user->fname = $data['given_name'];
            $user->lname = $data['family_name'];
            $user->email = $data['email'];
            $user->password = $this->generate_random_string();
            UserDataManager::add_new_user($user);
            $user = UserDataManager::get_user_by_email($data['email']);
            Membership::authenticate((object)$user);
        }
    }
    
    private function generate_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}