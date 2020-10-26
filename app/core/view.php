<?php

namespace App\Core;

class View {

    public static function view_exists($view) {
        $folder = SITE_STATUS == "Debug" ? "views" : "views/compressed";
        $real_path = ROOT_DIR . "/app/" . $folder . "/$view.php";
        if (file_exists($real_path)) {
            return true;
        }
        return false;
    }

    public static function load($view, $controller) {
        $model = $controller->model;
        $folder = SITE_STATUS == "Debug" ? "views" : "views/compressed";
        if (isset($controller->layout) && $controller->layout == "none") {
            $layout_path = ROOT_DIR . "/app/" . $folder . "/$view.php";
        } else {
            $layout = isset($controller->layout) && $controller->layout != "" ? $controller->layout : "default";
            $layout_path = ROOT_DIR . "/app/" . $folder . "/layout/$layout.php";
        }
        include_once($layout_path);
    }

    public static function render_shared($shared_view, $model = null) {
        $folder = SITE_STATUS == "Debug" ? "views" : "views/compressed";
        $real_path = ROOT_DIR . "/app/" . $folder . "/shared/$shared_view.php";
        if (file_exists($real_path)) {
            include($real_path);
        }
    }

    public static function render($view, $model) {
        $folder = SITE_STATUS == "Debug" ? "views" : "views/compressed";
        $real_path = ROOT_DIR . "/app/" . $folder . "/$view.php";
        include_once($real_path);
    }

    public static function render_script() {
        
    }

    public static function render_app_script($scripts) {
        $location = REAL_URL . "/app/scripts/app/";
        $vStr = "?v=" . SITE_VERSION;
        if (SITE_STATUS == "Live") {
            $location = REAL_URL . "/app/scripts/app/min/";
        }
        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                echo("<script src='$location$script.js$vStr'></script>\n");
            }
        } else {
            if ($scripts != "") {
                echo("<script src='$location$scripts.js$vStr'></script>");
            }
        }
    }

    public static function render_vendor_script($scripts) {
        $location = REAL_URL .  "/scripts/vendor/";
        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                echo("<script src='$location$script.js'></script>\n");
            }
        } else {
            if ($scripts != "") {
                echo("<script src='$location$scripts.js'></script>");
            }
        }
    }

    public static function render_proton_script($scripts) {
        $location = "/scripts/proton/";
        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                echo("<script src='$location$script.js'></script>\n");
            }
        } else {
            if ($scripts != "") {
                echo("<script src='$location$scripts.js'></script>");
            }
        }
    }

    public static function render_app_style($styles) {
        $location = REAL_URL . "/app/css/app/";
        $vStr = "?v=" . SITE_VERSION;
        if (SITE_STATUS == "Live") {
            $location = REAL_URL .  "/app/css/app/min/";
        }
        if (is_array($styles)) {
            foreach ($styles as $style) {
                echo("<link rel='stylesheet' href='$location$style.css$vStr'>\n");
            }
        } else {
            echo("<link rel='stylesheet' href='$location$styles.css$vStr'>\n");
        }
    }


}

?>
