<div class="card card-custom bg-dark-75 mb-8">
    <div class="card-header border-0">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-chat-1 text-white"></i>
            </span>
            <h3 class="card-label text-white">
                <?=(isset($model) ? $model->task_name : "") ?> (Optional)
            </h3>
        </div>
        <div class="card-toolbar">
            <span class="switch switch-outline switch-icon switch-success">
                <label>
                    <input type="checkbox" <?=(isset($model->data) ? "checked" : "") ?>  class="chk-optional" name="select"/>
                    <span></span>
                </label>
            </span>
        </div>
    </div>
    <div class="separator separator-solid separator-white opacity-20"></div>
    <div class="card-body text-white">


        <div class="form-group row">
            <div class="col-lg-6">
                <label class="text-white">Label</label>
                <input class="form-control task_name" <?=(isset($model->data) ? "" : "disabled") ?> readonly type="text" value="<?=(isset($model) ? $model->task_name : "") ?>" placeholder="Task/Interval Name" name="task_name[]"/>
            </div>
            <div class="col-lg-2">
                <label class="text-white">Duration</label>     
                <div class="input-group timepicker">
                    <input class="form-control duration" <?=(isset($model->data) ? "" : "disabled") ?> readonly placeholder="Select time" value="<?=(isset($model->data) ?  $model->data->duration[$model->ctr]  : "") ?>" type="text" name="duration[]"/>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-clock-o"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <label class="text-white">BG Color</label>
                <input class="form-control" <?=(isset($model->data) ? "" : "disabled") ?> type="color" value="<?=(isset($model->data) ?  $model->data->bg_color[$model->ctr]  : "#000000") ?>" name="bg_color[]"/>
            </div>
            <div class="col-lg-2">
                <label class="text-white">Text Color</label>
                <input class="form-control" <?=(isset($model->data) ? "" : "disabled") ?> type="color" value="<?=(isset($model->data) ?  $model->data->text_color[$model->ctr]  : "#ffffff") ?>" name="text_color[]"/>
            </div>
        </div>
    </div>
</div>