<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\DataManager\UserDataManager;
use App\Components\Membership;

class InvalidRequest extends BaseController{

    var $title = "Evermore Timer | Invalid Request";
    var $public = true;
    var $layout = "login";
    var $scripts = array();

    public function index(){
        
    }
}