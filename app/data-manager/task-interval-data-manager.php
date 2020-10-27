<?php
namespace App\DataManager;
use App\Components\Database;
use App\Components\Membership;
use App\Helpers\MailerHelper;

class TaskIntervalDataManager{
    public static function add_new_task_interval($task){
        if($task["id"] > 0){
            $result = Database::update("tasks", [
                'user_id' => Membership::current_user()->id,
                'task_intervals' => json_encode($task),
                'date_created' => date("Y-m-d h:i:s")],
                ['id' => $task["id"]]
            );  
        }else{
            $result = Database::insert("tasks", [
                'user_id' => Membership::current_user()->id,
                'task_intervals' => json_encode($task),
                'date_created' => date("Y-m-d h:i:s")
            ]);  
        }
        return $result;
    }
    
    public static function add_new_sub_task_interval($task){
        if($task["id"] > 0){
            Database::update("sub_tasks", [
                'user_id' => Membership::current_user()->id,
                'task_intervals' => json_encode($task),
                'date_created' => date("Y-m-d h:i:s")],
                ['id' => $task["id"]]
            );  
            $id = $task["id"];
        }else{
            $id = Database::insert("sub_tasks", [
                'user_id' => Membership::current_user()->id,
                'task_intervals' => json_encode($task),
                'date_created' => date("Y-m-d h:i:s")
            ]);  
        }
        return ($id);   
    }
    
    public static function get_sub_task_by_id($id){
        return Database::get("sub_tasks", "*", array("id" => $id));
    }
    
    public static function get_all_sub_task_by_ids($ids){
        $query = "SELECT * FROM sub_tasks "
                . "WHERE id " . (is_array($ids) ? " IN(" . implode(",", $ids) . ")" : " = " . $ids);
        return Database::query($query)->fetchAll();
        //return Database::select("tasks", "*", array("user_id" => Membership::current_user()->id));
    }
    public static function get_task_intervals_by_user_id(){
        $query = "SELECT tasks.* FROM tasks "
                . "WHERE user_id = " . Membership::current_user()->id . " "
                . "OR EXISTS"
                . "("
                . "     SELECT  shared_task.id FROM shared_task "
                . "     WHERE   shared_task.task_id = tasks.id"
                . "     AND     shared_task.user_id = " . Membership::current_user()->id . ""
                . ")";
        return Database::query($query)->fetchAll();
        //return Database::select("tasks", "*", array("user_id" => Membership::current_user()->id));
    }
    
    public static function get_task_intervals_by_id($id){
        return Database::get("tasks", "*", array("id" => $id));
    }
    
    public static function delete_task_intervals_by_id($id){
        if(is_array($id)){
            foreach($id as $_id){
                $task_user_id = Database::get("tasks", "user_id", array("id" => $_id));
                if($task_user_id != Membership::current_user()->id){
                    Database::query("DELETE FROM shared_task WHERE user_id = " . Membership::current_user()->id . " AND task_id = " . $_id);
                }else{
                    Database::query("DELETE FROM tasks WHERE id = " . $_id);
                }
            }
        }else{
            $task_user_id = Database::get("tasks", "user_id", array("id" => $id));
            if($task_user_id != Membership::current_user()->id){
                Database::query("DELETE FROM shared_task WHERE user_id = " . Membership::current_user()->id . " AND task_id = " . $id);
            }else{
                Database::query("DELETE FROM tasks WHERE id = " . $id);
            }
        }
    }
    
    public static function delete_sub_task_intervals_by_id($id){
        $query = "DELETE FROM `sub_tasks` "
                . "WHERE id" . (is_array($id) ? " IN(" . implode(",", $id) . ")" : " = " . $id);
        //die($query);
        Database::query($query);
    }
    
    public static function share_task_by_email($emails, $id){
        if(sizeof($emails) > 0){
            foreach ($emails as $_email){
                $request_id =  uniqid();  
                Database::insert("shared_task_request", [
                    'id' => $request_id,
                    'timer_ids' => $id,
                    'email' => $_email,
                    'status' => "PENDING",
                    'date_created' => date("Y-m-d h:i:s")
                ]);  
                
                MailerHelper::email_user($_email, $request_id);
            }
        }   
    }
    
    public static function get_task_invitation_by_id($id){
        $task_invitation = Database::get("shared_task_request", "*", array("id" => $id));
        return $task_invitation;
    }
    
    public static function accept_task_invitation($id, $ids, $email){
        $new_ids = array();
        if(is_array($ids)){
            $new_ids = $ids;
        }else{
            $new_ids[] = $ids;
        }
        
        if(sizeof($new_ids) > 0){
            foreach ($new_ids as $_id){
                $query = "INSERT INTO `shared_task`(task_id, user_id) "
                        . "SELECT $_id,users.id "
                        . "FROM `users` "
                        . "WHERE users.email = '$email' "
                        . "AND NOT EXISTS"
                        . "("
                        . "     SELECT  shared_task.id "
                        . "     FROM    `shared_task` "
                        . "     WHERE   shared_task.user_id = users.id "
                        . "     AND     shared_task.task_id = $_id"
                        . ")";
                Database::query($query);
            }
            Database::update("shared_task_request", [
                'status' => "ACCEPTED",
                'date_updated' => date("Y-m-d h:i:s")],
                ['id' => $id]
            );  
        }
    }
    
    
    
    public static function duplicate_task_by_id($ids){
        $new_ids = array();
        if(is_array($ids)){
            $new_ids = $ids;
        }else{
            $new_ids[] = $ids;
        }
        foreach($new_ids as $id){
            $task = Database::get("tasks", "*", array("id" => $id));
            if(!empty($task)){
                $intervals = json_decode($task['task_intervals']);
                if(isset($intervals->timer_type) && $intervals->timer_type == 4){
                    self::duplicate_compound($intervals);
                }else{
                    $result = Database::insert("tasks", [
                        'user_id' => Membership::current_user()->id,
                        'task_intervals' => $task['task_intervals'],
                        'date_created' => date("Y-m-d h:i:s")
                    ]); 
                }
            }
        }
        
        
//        $query = "INSERT INTO `tasks`(`user_id`, `task_intervals`, `date_created`) "
//                . "SELECT " .Membership::current_user()->id. ", `task_intervals`, '". date("Y-m-d h:i:s") ."' "
//                . "FROM `tasks` "
//                . "WHERE id" . (is_array($id) ? " IN(" . implode(",", $id) . ")" : " = " . $id);
        //die($query);
        //Database::query($query);
    }
    
    public static function duplicate_compound($intervals){
        if(is_array($intervals->sub_timers)){
            $new_sub_ids = array();
            foreach($intervals->sub_timers as $sub_timer){
                $sub_task = Database::get("sub_tasks", "*", array("id" => $sub_timer));
                $id = Database::insert("sub_tasks", [
                    'user_id' => Membership::current_user()->id,
                    'task_intervals' => $sub_task['task_intervals'],
                    'date_created' => date("Y-m-d h:i:s")
                ]); 
                $new_sub_ids[] = $id;
            }
            $intervals->sub_timers = $new_sub_ids;
            Database::insert("tasks", [
                'user_id' => Membership::current_user()->id,
                'task_intervals' => json_encode($intervals),
                'date_created' => date("Y-m-d h:i:s")
            ]); 
        }
    }
}
