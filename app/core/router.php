<?php

namespace App\Core;

class Router {

    public function __construct() {
        session_start();
    }

    public function init() {
        $controller = isset($_REQUEST["controller"]) ? $_REQUEST["controller"] : "home";
        $base_controller = $this->init_controller($controller);
        if ($base_controller) {
            $this->init_view($controller, $base_controller);
        }
    }

    public function init_controller($controller) {
        if (Controller::controller_exists($controller)) {
            return controller::load($controller);
        }
        return false;
    }

    public function init_model($model) {
        if (Model::model_exists($model)) {
            return Model::load($model);
        }
        return false;
    }

    public function init_view($view, $controller) {
        if (View::view_exists($view)) {
            return View::load($view, $controller);
        }
        return false;
    }

    public function load_vendors() {
        
    }

}

?>