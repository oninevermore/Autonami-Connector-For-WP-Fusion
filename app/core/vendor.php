<?php

namespace App\Core;

class Vendor {

    public static function load($vendor) {
        $real_path = ROOT_DIR . "/app/vendors/$vendor/autoload.php";
        if (file_exists($real_path)) {
            include_once($real_path);
        }
    }

}

?>