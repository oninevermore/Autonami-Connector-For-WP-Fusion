<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use App\Core\View;
use App\Components\Membership;
use App\DataManager\UserDataManager;

/**
 * Description of mailer-helper
 *
 * @author Onin
 */
class MailerHelper {
    public static function get_invitation_email_template($model){
        ob_start();
        View::render("mail-template/timer-invitation", $model);
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }
    
    public static function email_user($email, $invitation_id){
        $user = UserDataManager::get_user_by_email($email);
        $current_user = Membership::current_user();
        $model = new \stdClass;
        $model->first_name = $user['first_name'];
        $model->sender = $current_user->first_name . "  " . $current_user->last_name;
        $model->url = REAL_URL . "/task/accept-timer-invitation/" . $invitation_id;
        $email_body = self::get_invitation_email_template($model);
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <lee@evermoreventures.com>' . "\r\n";
        mail($email, "Evermore Timer Invitation", $email_body, $headers);
    }
}
