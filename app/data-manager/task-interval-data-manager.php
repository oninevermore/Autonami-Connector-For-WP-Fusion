<?php
namespace App\DataManager;
use App\Components\Database;
use App\Components\Membership;

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
    
    public static function unshare_task_intervals_by_id($id){
        Database::query("DELETE FROM shared_task WHERE id = " . $id);
    }
    
    public static function cancel_task_intervals_invitation_by_id($id){
        //die("DELETE FROM shared_task_request WHERE id = '" . $id . "'");
        Database::query("DELETE FROM shared_task_request WHERE id = '" . $id . "'");
        
    }
     
    public static function delete_sub_task_intervals_by_id($id){
        $query = "DELETE FROM `sub_tasks` "
                . "WHERE id" . (is_array($id) ? " IN(" . implode(",", $id) . ")" : " = " . $id);
        //die($query);
        Database::query($query);
    }
    
    public static function get_all_shared_tasks(){
        $query = "  SELECT  'INVITED' AS status, tasks.id, tasks.task_intervals, shared_task_request.id share_id, users.first_name, users.last_name, users.email 
                    FROM    `shared_task_request`, `tasks`, `users`
                    WHERE   users.email = shared_task_request.email
                    AND     tasks.id IN (shared_task_request.timer_ids)
                            AND tasks.user_id = " . Membership::current_user()->id . 
                    " AND     tasks.id NOT IN(SELECT task_id FROM shared_task WHERE shared_task.task_id = tasks.id AND shared_task.user_id = users.id)
                    UNION
                    SELECT  'SHARED' AS status, tasks.id, tasks.task_intervals, shared_task.id share_id, users.first_name, users.last_name, users.email 
                    FROM    `shared_task`
                    INNER   JOIN tasks ON tasks.id = shared_task.task_id
                    INNER   JOIN users ON users.id = shared_task.user_id
                    WHERE tasks.user_id = " . Membership::current_user()->id;
        
        $shared_timers = Database::query($query)->fetchAll();
        return $shared_timers;
    }
    
    public static function get_all_timer_invitations(){
        $query = "  SELECT  shared_task_request.status, users.id user_id, tasks.id, tasks.task_intervals, shared_task_request.id share_id, users.first_name, users.last_name, users.email 
                    FROM    `shared_task_request`, `tasks`, `users`
                    WHERE   users.id = tasks.user_id
                    AND     tasks.id IN (shared_task_request.timer_ids)
                    AND     shared_task_request.status = 'PENDING'
                    AND     shared_task_request.email = '" . Membership::current_user()->email . "' " .
                    "AND    tasks.id NOT IN(SELECT task_id FROM shared_task WHERE shared_task.task_id = tasks.id AND shared_task.user_id = users.id)";
        $timer_invitations = Database::query($query)->fetchAll();
        return $timer_invitations;
    }
    
    public static function add_shared_task_request_shown($id){
        Database::insert("shared_task_request_shown", [
            'id' => $id,
            'date_shown' => date("Y-m-d h:i:s")
        ]);  
    }
    
    public static function get_all_timer_invitations_not_shown(){
        $query = "  SELECT  shared_task_request.id, users.first_name, users.last_name, users.email 
                    FROM    `shared_task_request`, `tasks`, `users`
                    WHERE   users.id = tasks.user_id
                    AND     tasks.id IN (shared_task_request.timer_ids)
                    AND     shared_task_request.status = 'PENDING'
                    AND     shared_task_request.email = '" . Membership::current_user()->email . "' " .
                    "AND    tasks.id NOT IN(SELECT task_id FROM shared_task WHERE shared_task.task_id = tasks.id AND shared_task.user_id = users.id)
                    AND     shared_task_request.id NOT IN(SELECT shared_task_request_shown.id FROM shared_task_request_shown WHERE shared_task_request_shown.id = shared_task_request.id)";
        $timer_invitations = Database::query($query)->fetchAll();
        return $timer_invitations;
    }
    
    public static function get_ids_for_share($emails, $id){
        $ids = array();
        if(sizeof($emails) > 0){
            $_ids = explode(",", $id);
            foreach ($emails as $_email){
                if(is_array($_ids)){
                    foreach($_ids as $_id){
                        $request_id =  uniqid();  
                        Database::insert("shared_task_request", [
                            'id' => $request_id,
                            'timer_ids' => $_id,
                            'email' => $_email,
                            'status' => "PENDING",
                            'date_created' => date("Y-m-d h:i:s")
                        ]); 
                        $ids[] = array($_email, $request_id);
                    }
                }
            }
        }   
        return $ids;
    }
    
    public static function get_task_invitation_by_id($id){
        $task_invitation = Database::get("shared_task_request", "*", [
                "AND" => [
                    "id" => $id, 
                    "status" => "PENDING"
                ]
            ]);
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
    
    public static function reject_task_invitation($id){
        Database::update("shared_task_request", [
            'status' => "REJECTED",
            'date_updated' => date("Y-m-d h:i:s")],
            ['id' => $id]
        );  
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
