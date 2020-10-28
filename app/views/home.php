<div id="timerGrp">
    <div class="row">
        <!--begin::Timer-->
        <div class="col-md-12" >
            <div class="timer ml-auto mr-auto">
                <h1 id="maintimer">00:00:00</h1>
            </div>
        </div>
        <!--end::Timer-->
    </div>
    <div class="row" >
        <div class="col-4">
            <h2>Remaining</h2>
            <h3 id="remaining">00:00</h3>
        </div>
        <div class="col-4 text-center">
            <h2>Queue</h2>
            <h3 id="queue">0/0</h3>
        </div>
        <div class="col-4 text-right">
            <h2>Elapsed</h2>
            <h3 id="elapsed">00:00</h3>
        </div>
    </div>
</div>  
    
<div class="scroll scroll-pull" data-scroll="true" data-wheel-propagation="true" id="items" style="height: 200px"></div>

<div class="modal fade" id="modalItems" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saved Timer Sets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="scroll scroll-pull modal-scroll" data-scroll="true" data-wheel-propagation="true" style="height: 300px">
                    <div class="card-body pt-0" id="task-body">
                        <?php self::render_shared("timer-list", $model->task_details)?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" disabled class="btn btn-warning font-weight-bold tmr-btn duplicate">Duplicate</button>
                <button type="button" disabled class="btn btn-primary font-weight-bold tmr-btn share">Share</button>
                <button type="button" disabled class="btn btn-danger font-weight-bold tmr-btn deletetimer">Delete</button>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-success font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    New Timer
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item btnNewTimer" href="<?=REAL_URL?>/task?timer_type=0">Custom Timer</a>
                        <a class="dropdown-item btnNewTimer" href="<?=REAL_URL?>/task?timer_type=1">HIIT Timer</a>
                        <a class="dropdown-item btnNewTimer" href="<?=REAL_URL?>/task?timer_type=2">Round Timer</a>
                        <a class="dropdown-item btnNewTimer" href="<?=REAL_URL?>/task?timer_type=3">Circuit/Tabata Timer</a>
                        <a class="dropdown-item btnNewTimer" href="<?=REAL_URL?>/task?timer_type=4">Compound Timer</a>
                    </div>
                </div>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNewTimer" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="tmr-typ-name">New Timer Set</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="tmrBody">
                
            </div>
            <div class="modal-footer">
                <button id="btnSaveTaskInterval" type="button" class="btn btn-primary font-weight-bold">Save changes</button>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNewSubTimer" data-backdrop="static" tabindex="0" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="tmr-typ-name">New Sub Timer -  Timer Set</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="subTmrBody">
                
            </div>
            <div class="modal-footer">
                <button id="btnSaveSubTaskInterval" type="button" class="btn btn-primary font-weight-bold">Save changes</button>
                <button type="button" class="btn btn-light-primary font-weight-bold btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalShare" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Share Timer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmShare" method="post" action="<?=REAL_URL?>/task/share">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label>Enter email address:</label>
                            <input class="form-control" id="email_addresses" type="text" placeholder="Add email" name="email_addresses"/>
                            <input type="hidden" id="hd_task_id" name="id" value=""/>
                        </div>   
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnShareNow" type="button" class="btn btn-primary font-weight-bold">Share now</button>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectTimerType" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="radio-list">
                    <label class="radio radio-accent radio-primary">
                        <input type="radio" value="Custom Timer" checked name="timer_type"/>
                        <span></span>
                        Custom Timer
                    </label>
                    <label class="radio radio-accent radio-success">
                        <input type="radio" value="HIIT Timer"  name="timer_type"/>
                        <span></span>
                        HIIT Timer
                    </label>
                    <label class="radio radio-accent radio-warning">
                        <input type="radio" value="Circuit/Tabata Timer" name="timer_type"/>
                        <span></span>
                        Circuit/Tabata Timer
                    </label>
                    <label class="radio radio-accent radio-info">
                        <input type="radio" value="Round Timer"  name="timer_type"/>
                        <span></span>
                        Round Timer
                    </label>
<!--                    <label class="radio radio-accent radio-danger">
                        <input type="radio" value="Compound Timer"  name="timer_type"/>
                        <span></span>
                        Compound Timer
                    </label>-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold btn-go">Go</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalManageAccount" data-backdrop="static" tabindex="0" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="tmr-typ-name">Manage Account</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="manageAccountBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="btnlist">
    <a href="<?=REAL_URL?>/logout" title="Logout" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-danger"><i class="fas fa-sign-out-alt"></i></a>
    <button title="Manage Account" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-primary btnManageAccount"><i class="fas fa-user-edit"></i></button>
    <button title="Saved Timet Sets" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-info btnTimerSets"><i class="fas fa-th-list"></i></button>
    <div class="btn-group" role="group">
        <button title="New Timer Set" data-theme="dark" type="button" class="btn btn-success font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-plus-square"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item btnNewTimer" href="<?= REAL_URL ?>/task?timer_type=0">Custom Timer</a>
            <a class="dropdown-item btnNewTimer" href="<?= REAL_URL ?>/task?timer_type=1">HIIT Timer</a>
            <a class="dropdown-item btnNewTimer" href="<?= REAL_URL ?>/task?timer_type=2">Round Timer</a>
            <a class="dropdown-item btnNewTimer" href="<?= REAL_URL ?>/task?timer_type=3">Circuit/Tabata Timer</a>
            <a class="dropdown-item btnNewTimer" href="<?= REAL_URL ?>/task?timer_type=4">Compound Timer</a>
        </div>
    </div>
</div>
<div class="timer-control">
    <button title="Pause/Play" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-warning pause-play"><i class="far fa-pause-circle"></i></button>
    <button title="Restart" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-info restart-timer"><i class="fas fa-sync-alt"></i></button>
    <button title="Cancel Timer" data-toggle="tooltip" data-theme="dark" type="button" class="btn btn-icon btn-circle btn-lg mr-2 btn-danger cancel-timer"><i class="fas fa-times"></i></button>
</div>
    
<input type="hidden" id="timerDetails" value='<?=htmlentities($model->timer_details, ENT_QUOTES)?>'/>
<input type="hidden" id="currentTimer" value='<?=$model->current_timer?>'/>
<input type="hidden" id="allUsers" value='<?=$model->users?>'/>