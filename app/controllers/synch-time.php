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
        $clientTime = $_GET["ct"] * 1; //for php 5.2.1 or up: (float)$_GET["ct"];
        $this->model->serverTimestamp = round(microtime(true)*1000); // (new DateTime())->getTimestamp();
        $this->model->serverClientRequestDiffTime = $this->model->serverTimestamp - $clientTime;
        die(round(microtime(true)*1000) . "==" . time());
        $this->response_json($this->model);
    } 
}
