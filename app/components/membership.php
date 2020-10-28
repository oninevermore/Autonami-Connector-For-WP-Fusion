<?php

namespace App\Components;

class Membership {
    
    public static function is_authorize($page){
        if(isset($page->public) && $page->public === true){
            return true;
        }else{
            if (isset($_SESSION['AUTHENTICATION']) && $_SESSION['AUTHENTICATION'] == "EVERMORE-TIMER-" . session_id()) {
                if (isset($_SESSION['USERID']) && $_SESSION['USERID'] != "") {
                    return true;
                }
            }
            return false;
        }
    }
    
    public static function current_user(){
        $user = new \stdClass;
        $user->id = $_SESSION['USERID'];
        $user->first_name = $_SESSION['FIRSTNAME'];
        $user->last_name = $_SESSION['LASTNAME'];
        $user->email = $_SESSION['EMAIL'];
        return $user;
    }

    public static function authenticate($user){
        $_SESSION['AUTHENTICATION'] = "EVERMORE-TIMER-" . session_id();
        $_SESSION['USERID'] = $user->id;
        $_SESSION['FIRSTNAME'] = $user->first_name;
        $_SESSION['LASTNAME'] = $user->last_name;
        $_SESSION['EMAIL'] = $user->email;
    }
    
    public static function update_info($user){
       $_SESSION['FIRSTNAME'] = $user->first_name;
       $_SESSION['LASTNAME'] = $user->last_name; 
    }
    
    public static function de_authenticate(){
        unset($_SESSION['AUTHENTICATION']);
        unset($_SESSION['USERID']);
        unset($_SESSION['FIRSTNAME']);
        unset($_SESSION['LASTNAME']);
        unset($_SESSION['EMAIL']);
    }
}