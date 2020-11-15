<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Controllers;

use App\Core\BaseController;
/**
 * Description of synchtime
 *
 * @author Onin
 */
class SynchTime extends BaseController{
    public function index(){
        $this->model = new \stdClass;
        $this->model->result = "success";
        $this->model->time_now = time(); 
        $this->response_json($this->model);
    } 
}
