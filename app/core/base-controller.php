<?php

namespace App\Core;
use App\Components\Membership;

class BaseController {

    var $layout;
    var $page_styles = array();
    var $page_scripts = array();
    var $model;
    
    public function init($child) {
        $this->set_values($_REQUEST, $child);
        if(Membership::is_authorize($child)){
            if(isset($child->action)){
                $action = str_replace("-", "_", $child->action);
                if($action && method_exists($child, $action)){
                    $child->$action();
                }else{
                    $child->index();
                }
            }else{
                $child->index();
            }
        }else{
            header("location: " . REAL_URL . "/login?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        }
    }
    
    public function set_values($obj, $child) {
        if ($obj) {
            foreach ($obj as $key => $val) {
                $child->$key = $val;
            }
        }
    }
    
    public function redirect($target){
        header("location: $target");
    }
    
    public function render($view, $controller){
        View::load($view, $controller);
        die();
    }
    
    public function render_shared($view, $model){
        View::render_shared($view, $model);
        die();
    }
    
    public function response($content){
        header('Content-Type: text/html');
        die($content);
    }
    
    public function response_json($content){
        header('Content-Type: application/json');
        die(json_encode($content));
    }
}

