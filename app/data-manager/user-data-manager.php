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
    
    public static function update_password($user_id, $password, $request_id){
        Database::update("users", [
            'password' => crypt($password, self::$salt)],
            ['id' => $user_id]
        );  
        
        Database::update("password_request", [
            'status' => "ACCEPTED",
            'date_updated' => date("Y-m-d h:i:s")],
            ['id' => $request_id]
        ); 
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
    
    public static function add_user_password_request($id){
        $request_id =  uniqid(); 
        $result = Database::insert("password_request", [
            'id' => $request_id,
            'user_id' => $id,
            'status' => "PENDING",
            'date_created' => date("Y-m-d h:i:s")
        ]);

        return $request_id;
    }
    
    public static function get_password_request_by_id($id){
        $task_invitation = Database::get("password_request", "*", [
                "AND" => [
                    "id" => $id, 
                    "status" => "PENDING"
                ]
            ]);
        return $task_invitation;
    }
}
