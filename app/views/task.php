<form id="<?=$model->frm_name?>" action="<?=$model->action?>" method="post">
    <input type="hidden" name="id" value="<?=$model->id?>"/>    
    <input type="hidden" name="timer_type" value="<?=$model->timer_type?>"/>  
    <div class="form-group row">
        <div class="col-md-10">
            <label>Timer Set Name:</label>
            <input class="form-control" type="text" value="<?=$model->data->timer_set_name?>" placeholder="Timer Set Name" name="timer_set_name"/>
        </div>   
        <div class="col-md-2">
            <label>Number of Sets:</label>
            <input class="form-control" type="number" value="<?=$model->data->number_of_sets ?? "1"?>" placeholder="Number of Sets" name="number_of_sets"/>
        </div>   
    </div>
    <div class="form-group intervals">
        <?php
        if($model->timer_type == 1){
            App\Helpers\TaskHelper::render_interval_by_name($model, "High Intensity", false);
            App\Helpers\TaskHelper::render_interval_by_name($model, "Low Intensity", false);
        }elseif($model->timer_type == 2){
            App\Helpers\TaskHelper::render_interval_by_name($model, "Rounds", false);
            App\Helpers\TaskHelper::render_interval_by_name($model, "Break", false);
        }elseif($model->timer_type == 4){
            
        }else{
            if (is_array($model->data->task_name) && sizeof($model->data->task_name)) {
                $ctr = 0;
                $skip = array("Warm Up", "Cool Down", "Rest Between Sets", "Rest Between Intervals");
                foreach ($model->data->task_name as $task_name) {
                    if(!in_array($task_name, $skip)){
                        $sub_model = new \stdClass;
                        $sub_model->task_name = $task_name;
                        $sub_model->ctr = $ctr;
                        $sub_model->show_controls = true;
                        $sub_model->data = $model->data;
                        self::render_shared("task-interval", $sub_model);
                    }
                    $ctr++; 
                }
            } else {
                self::render_shared("task-interval", null);
            }
        }
        ?> 
        
    </div>
    <?php if($model->timer_type == 0 || $model->timer_type == 3){ ?>
        <div class="form-group">
            <button type="button" disabled class="btn btn-warning font-weight-bold task-btn duplicate-task-m">Duplicate</button>
                    <button type="button" disabled class="btn btn-danger font-weight-bold task-btn deletetask-m">Remove</button>
                    <button type="button" disabled class="btn btn-warning font-weight-bold paste">Paste</button>
            <a href="#" id="addTaskInterval" class="btn btn-sm btn-success font-weight-bold float-right mb-8">
                <i class="flaticon2-plus"></i> Add Task/Interval 
            </a>
        </div>
    <?php }?>
    
    <?php if($model->timer_type == 4){ ?>
    
        <div  class="form-group" id="sub-timer-list">
            <?php self::render_shared("sub-timer-list", $model->sub_timers)?>
        </div>
    
        <div class="form-group">
            <div class="btn-group" role="group">
                <button title="New Sub-Timer" data-theme="dark" type="button" class="btn btn-success font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-plus-square"></i> New Sub-Timer
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item btnNewSubTimer" href="<?= REAL_URL ?>/task?timer_type=0&is_subtimer=1">Custom Timer</a>
                    <a class="dropdown-item btnNewSubTimer" href="<?= REAL_URL ?>/task?timer_type=1&is_subtimer=1">HIIT Timer</a>
                    <a class="dropdown-item btnNewSubTimer" href="<?= REAL_URL ?>/task?timer_type=2&is_subtimer=1">Round Timer</a>
                    <a class="dropdown-item btnNewSubTimer" href="<?= REAL_URL ?>/task?timer_type=3&is_subtimer=1">Circuit/Tabata Timer</a>
                </div>
            </div>
        </div>
    <?php }?>
    
    <?php if($model->timer_type > 0){ ?>
        <?php if($model->timer_type == 4){ ?>
            <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Sub-Timers")?>
            <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Cycles")?> 
        <?php }else{ ?>
            <?php if($model->timer_type == 3){ ?>
                <div class="form-group">
                    <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Sets")?>
                    <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Intervals")?> 
                </div>
            <?php }?>

            <div class="form-group">
                <?php  App\Helpers\TaskHelper::render_optional($model, "Warm Up")?>
                <?php  App\Helpers\TaskHelper::render_optional($model, "Cool Down")?>
            </div>
        <?php }?>
    <?php }?>
</form>