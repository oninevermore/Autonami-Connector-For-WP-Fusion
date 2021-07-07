<?php
class  afwf_plugins_core{
    var $settings;
    public function init($child){
        $this->set_values($_REQUEST, $child);
        if(isset($this->action)){
            $action = str_replace("-", "_", $this->action) ;
            if($action && method_exists($child, $action)){
                $child->$action();
            }
        }
        
        if(isset($this->sub_action)){
            $action = str_replace("-", "_", $this->sub_action) ;
            if($action && method_exists($child, $action)){
                $child->$action();
            }
        }
    }
    public function set_values($obj, $child) {
        if ($obj) {
            foreach ($obj as $key => $val) {
                $child->$key = $val;
            }
        }
    }
    
    
    public function get_view($page=""){
        return AFWF_VIEWS_DIR . (!empty($page) ? $page : $this->page);
    }
    
    public function render_shared($shared, $model, $die = false){
        require AFWF_VIEWS_DIR . $shared . ".php";
        if($die){
            die();
        }
    }
    
    public function get_shared($shared, $model){
        ob_start();
        require AFWF_VIEWS_DIR . $shared . ".php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
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