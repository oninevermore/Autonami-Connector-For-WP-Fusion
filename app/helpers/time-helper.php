<?php

namespace App\Helpers;

class TimeHelper {
    public static function compute_compound_time($data){
//        if(isset($data->sub_timers) && is_array($data->sub_timers)){
//            $number_of_sets = isset($data->number_of_sets) ? $data->number_of_sets : 1;
//            for ($x = 1; $x <= $number_of_sets; $x++) {
//                foreach($data->sub_timers as $sub_timers){
//                    $sub_timer_set = TaskIntervalDataManager::get_sub_task_by_id($sub_timers);
//                    if(!empty($sub_timer_set)){
//                        $sub_data = json_decode($sub_timer_set["task_intervals"]);
//                        
//                    }
//                }
//                self::add_optional_by_name($data, "Rest Between Cycles", $json_data);
//            }
//        }
        return "00:00:00";
    }
    
    public static function compute_time($durations, $number_of_sets){
        if(is_array($durations)){
            $totalHours = 0;
            $totalMinutes = 0;
            $totalSeconds = 0;
            foreach ($durations as $duration) {
                $duration_split = explode(":", $duration);
                if(sizeof($duration_split) > 2){
                    $totalHours += intval($duration_split[0]);
                    $totalMinutes += intval($duration_split[1]);
                    $totalSeconds += intval($duration_split[2]);
                }
            }
            
            if($number_of_sets > 1){
                $totalHours = $totalHours * $number_of_sets;
                $totalMinutes = $totalMinutes * $number_of_sets;
                $totalSeconds = $totalSeconds * $number_of_sets;
            }
            
            if($totalSeconds >= 60){
                $remainingSeconds = floor($totalSeconds / 60);
                $totalSeconds = $totalSeconds - ($remainingSeconds * 60);
                $totalMinutes = $totalMinutes + $remainingSeconds;
            }
            
            if($totalMinutes >= 60){
                $remainingMinutes = floor($totalMinutes / 60);
                $totalMinutes = $totalMinutes - ($remainingMinutes * 60);
                $totalHours = $totalHours + $remainingMinutes;
            }
            
            return ($totalHours > 9 ? "" : "0") . $totalHours . ":" . ($totalMinutes > 9 ? "" : "0") . $totalMinutes . ":" . ($totalSeconds > 9 ? "" : "0") . $totalSeconds;
        }
        return "00:00:00";
    }
    
    public static function compute_total_seconds($duration, $number_of_sets){
        $duration_split = explode(":", $duration);

        $totalHours = intval($duration_split[0]) * $number_of_sets;
        $totalMinutes = intval($duration_split[1]) * $number_of_sets;
        $totalSeconds = intval($duration_split[2]) * $number_of_sets;
        
        return ($totalHours * 3600) + ($totalMinutes * 60) + $totalSeconds;
    }
}