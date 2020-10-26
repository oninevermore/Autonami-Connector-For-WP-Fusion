<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use App\Core\View;
use App\Components\Membership;
use App\DataManager\TaskIntervalDataManager;
use App\DataManager\CurrentTimerDataManager;
use App\Helpers\TimeHelper;

/**
 * Description of task-helper
 *
 * @author Onin
 */
class TaskHelper {
    static $skipped_intervals = array("Warm Up", "Cool Down", "Rest Between Sets", "Rest Between Intervals");
    
    public static function get_task_details($id){
        $json_data = array();
        if(!empty($id)){
            $timer_set = TaskIntervalDataManager::get_task_intervals_by_id($id);
            if(!empty($timer_set)){
                $data = json_decode($timer_set["task_intervals"]);
                if(isset($data->timer_type) && $data->timer_type == 4){
                    if(isset($data->sub_timers) && is_array($data->sub_timers)){
                        $number_of_sets = isset($data->number_of_sets) ? $data->number_of_sets : 1;
                        for ($x = 1; $x <= $number_of_sets; $x++) {
                            foreach($data->sub_timers as $sub_timers){
                                $sub_timer_set = TaskIntervalDataManager::get_sub_task_by_id($sub_timers);
                                if(!empty($sub_timer_set)){
                                    $sub_data = json_decode($sub_timer_set["task_intervals"]);
                                    self::add_timer_set($sub_data, $json_data);
                                    self::add_optional_by_name($data, "Rest Between Sub-Timers", $json_data);
                                }
                            }
                            self::add_optional_by_name($data, "Rest Between Cycles", $json_data);
                        }
                    }
                }else{
                    self::add_timer_set($data, $json_data);
                }
                
            } 
        }
        return($json_data);
    }
    
    private static function add_timer_set($data, &$json_data){
        if(is_array($data->task_name) && sizeof($data->task_name)){
                    
            self::add_optional_by_name($data, "Warm Up", $json_data);

            $number_of_sets = isset($data->number_of_sets) ? $data->number_of_sets : 1;
            for ($x = 1; $x <= $number_of_sets; $x++) {
                $ctr = 0;
                foreach($data->task_name as $task_name){
                    if(!in_array($task_name, self::$skipped_intervals)){
                        $details = new \stdClass;
                        $details->title = $task_name;
                        $details->time = $data->duration[$ctr];
                        $details->total_seconds = TimeHelper::compute_total_seconds($data->duration[$ctr], 1);
                        $details->color = $data->bg_color[$ctr];
                        $details->t_color = $data->text_color[$ctr];
                        $details->instruction = isset($data->instruction[$ctr]) ? $data->instruction[$ctr] : "";
                        $json_data[] = $details;    
                        self::add_optional_by_name($data, "Rest Between Intervals", $json_data);
                    }
                    $ctr++;
                }

                self::add_optional_by_name($data, "Rest Between Sets", $json_data);
            }

            self::add_optional_by_name($data, "Cool Down", $json_data);

        }
    }
    
    private static function add_optional_by_name($data, $task_name, &$json_data){
        $optional_index = self::get_task_index_by_name($data, $task_name);
        if($optional_index !== null){
            $total_warm_up_seconds = TimeHelper::compute_total_seconds($data->duration[$optional_index], 1);
            if($total_warm_up_seconds > 0){
                $details = new \stdClass;
                $details->title = substr($task_name, 0, 4) == "Rest" ? "Rest" : $task_name;
                $details->time = $data->duration[$optional_index];
                $details->total_seconds = TimeHelper::compute_total_seconds($data->duration[$optional_index], 1);
                $details->color = $data->bg_color[$optional_index];
                $details->t_color = $data->text_color[$optional_index];
                $details->instruction = isset($data->instruction[$optional_index]) ? $data->instruction[$optional_index] : "";
                $json_data[] = $details; 
            }
        }
    }
    
    
    public static function get_current_timer(){
        $result = CurrentTimerDataManager::get_current_timer_by_user();
        if(is_array($result) && sizeof($result) > 0){   
            foreach($result as $item){
                $item = (object)$item;
                if($item->user_id == Membership::current_user()->id){
                    $current_timer = (object)$item;
                    $current_timer->time_now = time();
                    return array(
                        "current_timer" => json_encode($current_timer), 
                        "timer_details" => json_encode(self::get_task_details($item->task_id))
                    );
                }
            }
            $current_timer = (object)$result[0];
            $current_timer->time_now = time();
            return array(
                "current_timer" => json_encode($current_timer), 
                "timer_details" => json_encode(self::get_task_details($result[0]["task_id"]))
            );
        }
        return array(
            "current_timer" => "", 
            "timer_details" => ""
        );
    }
    
    public static function get_task_intervals_by_user_id(){
        $tasks = TaskIntervalDataManager::get_task_intervals_by_user_id();
        $task_details = array();
        if(is_array($tasks)){
            foreach($tasks as $task){
                $full_details = json_decode($task["task_intervals"]);
                
                $task_detail = new \stdClass;
                $task_detail->id = $task["id"];
                $task_detail->timer_set_name = $full_details->timer_set_name;
                $task_detail->total_time = isset($full_details->timer_type) && $full_details->timer_type == 4 ? 
                                                TimeHelper::compute_compound_time($full_details->sub_timers) : 
                                                TimeHelper::compute_time($full_details->duration, isset($full_details->number_of_sets) ? $full_details->number_of_sets : 1);
                if(isset($full_details->timer_type) && $full_details->timer_type == 4){
                    $color = self::get_compound_default_color($full_details->sub_timers);
                    $task_detail->bg_color = $color["bg_color"];
                    $task_detail->text_color = $color["text_color"];
                    $task_detail->total_sets = sizeof($full_details->sub_timers) . " Sub Timers";
                }else{
                    $task_detail->bg_color = $full_details->bg_color[0];
                    $task_detail->text_color = $full_details->text_color[0];
                    $task_detail->total_sets = sizeof($full_details->duration) . " sets";
                }
                $task_detail->button_state = $task["user_id"] == Membership::current_user()->id ? "" : "disabled";
                $task_details[] = $task_detail;
            }
        }   
        return $task_details;
    }
    
    public static function get_compound_default_color($sub_timers){
        if(is_array($sub_timers) && sizeof($sub_timers) > 0){
            $subtimer = TaskIntervalDataManager::get_sub_task_by_id($sub_timers[0]);
            $full_details = json_decode($subtimer["task_intervals"]);
            return array(
                "bg_color" => $full_details->bg_color[0],
                "text_color" => $full_details->text_color[0]
            );
        }
        return array(
            "bg_color" => "000000",
            "text_color" => "ffffff"
        );
    }


    public static function get_sub_task_intervals_by_ids($ids){
        $tasks = TaskIntervalDataManager::get_all_sub_task_by_ids($ids);
        $task_details = array();
        if(is_array($tasks)){
            foreach($tasks as $task){
                $full_details = json_decode($task["task_intervals"]);
                $task_detail = new \stdClass;
                $task_detail->id = $task["id"];
                $task_detail->timer_set_name = $full_details->timer_set_name;
                $task_detail->total_time = TimeHelper::compute_time($full_details->duration, isset($full_details->number_of_sets) ? $full_details->number_of_sets : 1);
                $task_detail->bg_color = $full_details->bg_color[0];
                $task_detail->text_color = $full_details->text_color[0];
                $task_detail->total_sets = sizeof($full_details->duration) . " sets";
                $task_detail->button_state = $task["user_id"] == Membership::current_user()->id ? "" : "disabled";
                $task_details[] = $task_detail;
            }
        }
        
        return $task_details;
    }
    
    public static function render_interval_by_name($model, $task_name, $show_controls){
        $ctr = self::get_task_index_by_name($model->data, $task_name);
        if($ctr === null){
            $sub_model = new \stdClass;
            $sub_model->task_name = $task_name;
            $sub_model->ctr = 0;
            $sub_model->show_controls = $show_controls;
            $sub_model->data = null;
            View::render_shared("task-interval", $sub_model);
        }else{
            $sub_model = new \stdClass;
            $sub_model->task_name = $task_name;
            $sub_model->ctr = $ctr;
            $sub_model->show_controls = $show_controls;
            $sub_model->data = $model->data;
            View::render_shared("task-interval", $sub_model);
        }
    }
    
    public static function render_optional($model, $task_name){
        //var_dump($model->data->task_name);
        if (isset($model->data->task_name) && is_array($model->data->task_name) && sizeof($model->data->task_name)) {
            $ctr = self::get_task_index_by_name($model->data, $task_name);
            
            if($ctr === null){
                $opt_model = new \stdClass;
                $opt_model->task_name = $task_name;
                $opt_model->ctr = $ctr;
                View::render_shared("task-interval-optional", $opt_model);
            }else{
                $opt_model = new \stdClass;
                $opt_model->task_name = $task_name;
                $opt_model->ctr = $ctr;
                $opt_model->data = $model->data;
                View::render_shared("task-interval-optional", $opt_model);
            }
        } else {
            $opt_model = new \stdClass;
            $opt_model->task_name = $task_name;
            $opt_model->ctr = 0;
            View::render_shared("task-interval-optional", $opt_model);
        }
    }
    
    public static function get_task_index_by_name($data, $_task_name){
        if (isset($data->task_name) && is_array($data->task_name)) {
            $ctr = 0;
            foreach ($data->task_name as $task_name) {
                if($task_name == $_task_name){
                    return $ctr;
                }
                $ctr++;
            }
        }
        return null;
    }
}
