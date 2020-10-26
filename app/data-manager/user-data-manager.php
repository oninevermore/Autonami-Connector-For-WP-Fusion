<?php
namespace App\DataManager;
use App\Components\Database;

class UserDataManager{

    static $salt = '$1$easy-acc-usr$';

    public static function add_new_user($user){
    
        $result = Database::insert("users", [
            'first_name' => $user->fname,
            'last_name' => $user->lname,
            'email' => $user->email,
            'password' => crypt($user->password, self::$salt),
        ]);

        return $result;
    }
    
    public static function is_email_exists($email){
        return Database::has("users", ["AND" => ["email" => $email]]);
    }

    public static function is_valid_credential($email, $password){
        return Database::has(
            "users", 
            [
                "AND" => [
                    "email" => $email, 
                    "password" => crypt($password, self::$salt)
                ]
            ]
        );
    }
    
    public static function get_user($email, $password){
        return Database::get(
            "users", 
            [
                "id",
                "first_name",
                "last_name",
                "email"
            ],
            [
                "AND" => [
                    "email" => $email, 
                    "password" => crypt($password, self::$salt)
                ]
            ]
        );
    }
    
    public static function get_user_by_email($email){
        return Database::get(
            "users", 
            [
                "id",
                "first_name",
                "last_name",
                "email"
            ],
            [
                "email" => $email
            ]
        );
    }
    
    public static function get_all_user(){
        return Database::select("users", array("first_name", "last_name", "email"));
    }
}
