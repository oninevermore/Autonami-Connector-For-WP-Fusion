<?php

namespace App\Core;

class Model {

    public static function model_exists($model) {
        $real_path = ROOT_DIR . "/models/$model.php";
        if (file_exists($real_path)) {
            return true;
        }
        return false;
    }

    public static function load($model) {
        $real_path = ROOT_DIR . "/models/$model.php";
        include_once($real_path);
        return new $model();
    }

}
