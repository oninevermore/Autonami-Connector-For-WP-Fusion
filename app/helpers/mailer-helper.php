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
    public static function get_email_template($model, $file){
        ob_start();
        View::render("mail-template/$file", $model);
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }
    
    public static function send_timer_invitation_email($email, $invitation_id){
        $user = UserDataManager::get_user_by_email($email);
        $current_user = Membership::current_user();
        $model = new \stdClass;
        $model->first_name = $user['first_name'];
        $model->sender = $current_user->first_name . "  " . $current_user->last_name;
        $model->url = REAL_URL . "/task/accept-timer-invitation/" . $invitation_id;
        $email_body = self::get_email_template($model, "timer-invitation");
        
        self::send_html_email($email, "Evermore Timer Invitation", $email_body);
    }
    
    public static function send_forgot_password_email($email, $first_name, $request_id){
        $model = new \stdClass;
        $model->first_name = $first_name;
        $model->url = REAL_URL . "/password-reset/" . $request_id;
        $email_body = self::get_email_template($model, "password-request");
        self::send_html_email($email, "Evermore Timer Password Reset", $email_body);
    }
    
    public static function send_html_email($email, $subject, $body, $from = "admin@evermoreventures.com"){
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <' . $from . '>' . "\r\n";
        mail($email, $subject, $body, $headers);
    }
}
