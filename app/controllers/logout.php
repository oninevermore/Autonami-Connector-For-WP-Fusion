<?php

namespace App\Controllers;

use \App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;

class Logout extends BaseController{

    var $title = "Logout";
    var $public = true;

    public function index(){
        Membership::de_authenticate();
        header("location: " . REAL_URL . "/login");
    }
}