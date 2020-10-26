<?php

namespace App\Core;

class Controller {

    public static function controller_exists($controller) {
        $real_path = ROOT_DIR . "/app/controllers/$controller.php";
        if (file_exists($real_path)) {
            return true;
        }
        return false;
    }

    public static function load($controller) {
        $real_path = ROOT_DIR . "/app/controllers/$controller.php";
        include_once($real_path);
        $controller_clean = str_replace(" ", "", ucwords(str_replace("-", " ", $controller)));
        
        $class_name = "\app\controllers\\" . $controller_clean;
        $new_controller = new $class_name();
        $new_controller->init($new_controller);
        return $new_controller;
    }


    public static function load_vendor($vendor) {
        include_once(ROOT_DIR . "/app/vendors/$vendor/$vendor.php");
    }

    public static function load_extension($extensions) {
        $new_extensions = array();
        if (is_array($extensions)) {
            foreach ($extensions as $ext) {
                $real_path = ROOT_DIR . "/app/controllers/$ext.php";
                include_once($real_path);
                $ext_clean = str_replace("-", "_", $ext);
                $new_extensions[] = new $ext_clean();
            }
        }
        return $new_extensions;
    }

}