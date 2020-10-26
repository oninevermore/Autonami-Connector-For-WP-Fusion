<form id="frmTask" action="<?=REAL_URL?>/task/save" method="post">
    <input type="hidden" name="id" value="<?=$model->id?>"/>    
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
    <div>
        <?php
        if (is_array($model->data->task_name) && sizeof($model->data->task_name)) {
            $ctr = 0;
            foreach ($model->data->task_name as $task_name) {
                $sub_model = new \stdClass;
                $sub_model->task_name = $task_name;
                $sub_model->ctr = $ctr;
                $sub_model->data = $model->data;
                self::render_shared("task-interval", $sub_model);
                $ctr++;
            }
        } else {
            self::render_shared("task-interval", null);
        }
        ?> 
        <a href="#" id="addTaskInterval" class="btn btn-sm btn-success font-weight-bold float-right mb-8">
            <i class="flaticon2-plus"></i> Add Task/Interval
        </a>
    </div>
    <?php if($model->timer_type == 2){ ?>
        <div style="clear: both">
            <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Intervals")?> 
        </div>

        <div style="clear: both">
            <?php  App\Helpers\TaskHelper::render_optional($model, "Rest Between Sets")?>
        </div>
    <?php }?>
    <div style="clear: both">
        <?php  App\Helpers\TaskHelper::render_optional($model, "Warm Up")?>
    </div>
    
    <div>
        <?php  App\Helpers\TaskHelper::render_optional($model, "Cool Down")?>
    </div>
</form>