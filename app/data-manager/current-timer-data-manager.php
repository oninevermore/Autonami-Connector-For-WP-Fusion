<?php
namespace App\DataManager;
use App\Components\Database;
use App\Components\Membership;

class CurrentTimerDataManager{
    public static function add_new_timer($timer){
        $time = time();
        if($timer->id > 0){
            $data = [
                'task_id' => $timer->task_id,
                'status' => $timer->status,
                'last_time_updated' => $time,
                'elapsed_time' => $timer->elapsed_time
            ];
            if($timer->status == "RUNNING"){
                $data["date_started"] = $time - $timer->elapsed_time;
            }
            
            $result = Database::update("current_timers", 
                $data,
                ['id' => $timer->id]
            );  
        }else{
            $result = Database::insert("current_timers", [
                'task_id' => $timer->task_id,
                'status' => $timer->status,
                'user_id' => Membership::current_user()->id,
                'date_started' => $time,
                'last_time_updated' => $time
            ]);  
        }
        
        return self::get_latest_current_timer($timer->id ?? 0);
    }
    
    public static function get_latest_current_timer($id){
        if($id > 0){
            $query = "SELECT * FROM current_timers WHERE id = $id";
        }else{
            $query = "SELECT t1.* FROM current_timers t1 "
                    . "WHERE t1.id = "
                    . "("
                    . "     SELECT MAX(t2.id) FROM current_timers t2"
                    . ")";
        }
        $result = Database::query($query)->fetchAll();
        
        if(is_array($result) && sizeof($result) > 0){
            return (object)$result[0];
        }else{
            return null;
        }
    }
    
    public static function get_current_timer_by_user(){
        $query = "SELECT * FROM current_timers "
                . "WHERE "
                . "("
                . "     user_id = '". Membership::current_user()->id ."'"
                . "     OR   EXISTS"
                . "     ("
                . "         SELECT  shared_task.task_id FROM shared_task"
                . "         WHERE   shared_task.task_id = current_timers.task_id"
                . "         AND     shared_task.user_id = '". Membership::current_user()->id ."'"
                . "     )"
                . ")"
                . "AND  STATUS <> 'DONE'";
        return Database::query($query)->fetchAll();
    }
}