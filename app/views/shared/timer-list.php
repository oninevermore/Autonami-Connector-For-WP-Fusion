<?php if(is_array($model) && sizeof($model) > 0){?>
    <?php foreach($model as $item){?>
        <!--begin::Item-->
        <div class="d-flex align-items-center mb-9 rounded p-5 item-panel" style="background-color: <?=$item->bg_color?>">
            <!--begin::Icon-->
            <div class="checkbox-inline chk chk-tmr">
                <label class="checkbox checkbox-outline checkbox-success checkbox-lg">
                    <input type="checkbox" name="id[]" value="<?=$item->id?>"/>
                    <span style="border-color: <?=$item->text_color?>!important"></span>
                </label>
            </div>
            <i class="icon-2x flaticon-stopwatch mr-5 ml-3" style="color: <?=$item->text_color?>"></i>
            
            <!--end::Icon-->
            <!--begin::Title-->
            <div class="d-flex flex-column flex-grow-1 mr-2">
                <a href="#" data-id="<?=$item->id?>" class="font-weight-bold text-hover-primary font-size-lg mb-1 run" style="color: <?=$item->text_color?>"><?=$item->timer_set_name?></a>
                <span class="font-weight-bold" style="color: <?=$item->text_color?>; opacity: .6"><?=$item->total_sets?> | <?=$item->total_time?></span>
            </div>
            <!--end::Title-->
            <!--begin::Lable-->
            <span class="font-weight-bolder text-warning py-1 font-size-lg">
                <button title="Run Timer" data-toggle="tooltip" data-theme="dark" type="button" data-id="<?=$item->id?>" class="btn btn-icon btn-info btn-circle btn-sm mr-2 run"><i class="flaticon-time"></i></button>
                <button title="Duplicate Timer" data-toggle="tooltip" data-theme="dark" type="button" data-id="<?=$item->id?>" class="btn btn-icon btn-warning btn-circle btn-sm mr-2 duplicate"><i class="fab fa-creative-commons-share"></i></button>
                <button title="Share Timer" data-toggle="tooltip" data-theme="dark" type="button" data-id="<?=$item->id?>" class="btn btn-icon btn-primary btn-circle btn-sm mr-2 share"><i class="fas fa-share-alt"></i></button>
                <button title="Edit Timer Set" <?=$item->button_state?> data-toggle="tooltip" data-theme="dark" type="button" data-id="<?=$item->id?>" class="btn btn-icon btn-success btn-circle btn-sm mr-2 edit-timer"><i class="flaticon-edit-1"></i></button>
                <button data-id="<?=$item->id?>" <?=$item->button_state?> title="Delete" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-danger btn-circle btn-sm mr-2 deletetimer"><i class="flaticon-cancel"></i></button>
            </span>
            <!--end::Lable-->
        </div>
        <!--end::Item-->
    <?php }?>
<?php }else{?>
    <div class="alert alert-info text-center">There were no saved Timer Sets yet. You can start adding new Timer Sets now.</div>
<?php }?>