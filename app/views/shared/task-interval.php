<div class="card card-custom bg-success mb-8">
    <div class="card-header border-0">
        <div class="card-title">
            <?php if((isset($model) && $model->show_controls) || $model == null){?>
            <div class="checkbox-inline chk">
                <label class="checkbox checkbox-outline checkbox-primary checkbox-md">
                    <input type="checkbox" class="chk-intvl" />
                    <span></span>
                </label>
            </div>
            <?php }?>
            <span class="card-icon">
                <i class="flaticon2-chat-1 text-white"></i>
            </span>
            <h3 class="card-label text-white">
                Task/Interval
            </h3>
        </div>
        <div class="card-toolbar">
            <?php if((isset($model) && $model->show_controls) || $model == null){?>
            <button type="button" class="copy-int-task btn btn-sm btn-info font-weight-bold mr-3">
                <i class="fas fa-copy"></i> Copy
            </button>
            <button type="button" class="duplicate-int-task btn btn-sm btn-warning font-weight-bold mr-3">
                <i class="fab fa-creative-commons-share"></i> Duplicate
            </button>
            <button type="button" class="remove-int-task btn btn-sm btn-danger font-weight-bold <?= (isset($model) ? ($model->ctr == 0 ? "disabled" : "") : "disabled")?>">
                <i class="flaticon-cancel"></i> Remove 
            </button>
            <?php }?>
        </div>
    </div>  
    <div class="separator separator-solid separator-white opacity-20"></div>
    <div class="card-body text-white">


        <div class="form-group row">
            <div class="col-lg-6">
                <label>Label</label>
                <input <?= ((isset($model) && $model->show_controls) || $model == null ? "" : "readonly")?> class="form-control task_name"  type="text" value="<?=(isset($model) ? $model->task_name : "") ?>" placeholder="Task/Interval Name" name="task_name[]"/>
            </div>
            <div class="col-lg-2">
                <label>Duration</label>     
                <div class="input-group timepicker">
                    <input class="form-control duration" placeholder="Select time" value="<?=(isset($model->data) ?  $model->data->duration[$model->ctr]  : "") ?>" type="text" name="duration[]"/>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-clock-o"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <label>BG Color</label>
                <input class="form-control" type="color" value="<?=(isset($model->data) ?  $model->data->bg_color[$model->ctr]  : "#000000") ?>" name="bg_color[]"/>
            </div>
            <div class="col-lg-2">
                <label>Text Color</label>
                <input class="form-control" type="color" value="<?=(isset($model->data) ?  $model->data->text_color[$model->ctr]  : "#ffffff") ?>" name="text_color[]"/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-12">
                <label>Instruction</label>
                <textarea rows="3" class="form-control instruction" placeholder="Text to speech instruction here."  name="instruction[]"><?=(isset($model->data->instruction) ?  $model->data->instruction[$model->ctr]  : "") ?></textarea>
            </div>
        </div>
    </div>
</div>