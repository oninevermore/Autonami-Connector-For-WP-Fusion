<div class="example-preview">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#account">
                <span class="nav-icon">
                    <i class="fas fa-user-edit"></i>
                </span>
                <span class="nav-text">Account</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#shared-timer" aria-controls="shared-timer">
                <span class="nav-icon">
                    <i class="flaticon-stopwatch"></i>
                </span>
                <span class="nav-text">Shared Timers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#timer-invitations" aria-controls="timer-invitations">
                <span class="nav-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <span class="nav-text">Timer Invitations</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-tab">
            <form  action="<?=REAL_URL?>/manage-account/save" method="post">
                <div class="form-group">
                    <h3 class="font-weight-bolder text-dark display5">Account Info</h3>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Email:</label>
                        <input class="form-control" disabled type="text" value="<?=$model->user->email?>" />
                    </div>   
                    <div class="col-md-4">
                        <label>Firstname:</label>
                        <input class="form-control" type="text" value="<?=$model->user->first_name?>" placeholder="Firstname" name="first_name"/>
                    </div>  
                    <div class="col-md-4">
                        <label>Lastname:</label>
                        <input class="form-control" type="text" value="<?=$model->user->last_name?>" placeholder="Firstname" name="last_name"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary font-weight-bold save-account">Update</button>
                    </div>
                </div>
            </form>
            <form  action="<?=REAL_URL?>/manage-account/change-password" method="post">
                <div class="form-group">
                    <h3 class="font-weight-bolder text-dark display5">Change Password</h3>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>New Password:</label>
                        <input class="form-control" type="password" placeholder="New Password" name="password"/>
                    </div>  
                    <div class="col-md-4">
                        <label>Re-enter Password:</label>
                        <input class="form-control" type="password" placeholder="Re-enter Password" name="cpassword"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary font-weight-bold  save-account">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="shared-timer" role="tabpanel" aria-labelledby="shared-timer-tab">
            <div class="accordion accordion-solid accordion-toggle-plus" id="c">
                <?php 
                    if(is_array($model->shared_timers) && sizeof($model->shared_timers) > 0) {
                        $ctr=0;
                        foreach($model->shared_timers as $shared_timers){
                ?>
                    <div class="card">
                        <div class="card-header" id="headingOne6">
                            <div class="card-title<?=($ctr == 0 ? "" : " collapsed")?>" data-toggle="collapse" data-target="#collapseOne<?=$shared_timers["id"]?>">
                                <i class="flaticon-stopwatch"></i> <?=$shared_timers["name"]?>
                            </div>
                        </div>
                        <div id="collapseOne<?=$shared_timers["id"]?>" class="collapse <?=($ctr == 0 ? "show" : "")?>" data-parent="#accordionInvitations">
                            <div class="card-body">
                                <?php 
                                if(is_array($shared_timers["users"]) && sizeof($shared_timers["users"]) > 0) {
                                    foreach($shared_timers["users"] as $users){
                                    ?>
                                    <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5 user-pnl">
                                        <!--begin::Icon-->
                                        <span class="svg-icon svg-icon-success mr-5">
                                            <span class="svg-icon svg-icon-lg">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Communication/Write.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"><?=$users["first_name"]?> <?=$users["last_name"]?></a>
                                            <span class="text-muted font-weight-bold"><?=$users["email"]?></span>
                                        </div>
                                        <!--end::Title-->
                                        <?php if($users["status"] == "SHARED") { ?>
                                            <span class="label label-lg label-success label-inline mt-lg-0 mr-5 mb-lg-0 my-2 font-weight-bold py-4">Shared</span>
                                            <!--begin::Lable-->
                                            <button type="button" class="btn  btn-danger font-weight-bold btn-sm remove-share" data-share_id='<?=$users["share_id"]?>'>
                                                <i class="flaticon-cancel"></i> Remove
                                            </button>
                                            <!--end::Lable-->
                                        <?php }else{ ?>
                                            <span class="label label-lg label-warning label-inline mt-lg-0 mr-5 mb-lg-0 my-2 font-weight-bold py-4">Awaiting</span>
                                            <!--begin::Lable-->
                                            <button type="button" class="btn  btn-danger font-weight-bold btn-sm cancel-invitation" data-share_id='<?=$users["share_id"]?>'>
                                                <i class="flaticon-cancel"></i> Cancel
                                            </button>
                                            <!--end::Lable-->
                                        <?php } ?>
                                    </div>
                                    
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php 
                            $ctr++;
                        }
                    }else{
                    ?>  
                    <div class='alert alert-danger'>
                        <span>There were no shared timers yet.</span>
                    </div>
                    <?php
                    }
                ?>
            </div>
        </div>
        
        <div class="tab-pane fade" id="timer-invitations" role="tabpanel" aria-labelledby="timer-invitation-tab">
            <div class="accordion accordion-solid accordion-toggle-plus" id="accordionInvitations">
                <?php 
                    if(is_array($model->timer_invitations) && sizeof($model->timer_invitations) > 0) {
                        $ctr=0;
                        foreach($model->timer_invitations as $timer_invitations){
                ?>
                    <div class="card">
                        <div class="card-header" id="headingOne6">
                            <div class="card-title<?=($ctr == 0 ? "" : " collapsed")?>" data-toggle="collapse" data-target="#collapseOne<?=$timer_invitations["user_id"]?>">
                                <i class="far fa-user-circle"></i> <?=$timer_invitations["first_name"]?> <?=$timer_invitations["last_name"]?>
                                <small class="text-muted font-weight-bold">(<?=$timer_invitations["email"]?>)</small>
                            </div>
                        </div>
                        <div id="collapseOne<?=$timer_invitations["user_id"]?>" class="collapse <?=($ctr == 0 ? "show" : "")?>" data-parent="#accordionInvitations">
                            <div class="card-body">
                                <?php 
                                if(is_array($timer_invitations["invitations"]) && sizeof($timer_invitations["invitations"]) > 0) {
                                    foreach($timer_invitations["invitations"] as $timer){
                                    ?>
                                    <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5 user-pnl">
                                        <!--begin::Icon-->
                                        <i class="flaticon-stopwatch text-success mr-2"></i>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <a href="#" class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"><?=$timer["name"]?></a>
                                        </div>
                                        <!--end::Title-->
                                        <button type="button" class="btn  btn-danger font-weight-bold btn-sm reject-invitation  mr-2" data-share_id='<?=$timer["share_id"]?>'>
                                            <i class="flaticon-cancel"></i> Reject
                                        </button>
                                        <button type="button" class="btn  btn-success font-weight-bold btn-sm approved-invitation" data-share_id='<?=$timer["share_id"]?>'>
                                            <i class="fas fa-check-circle"></i> Approved
                                        </button>
                                    </div>
                                    
                                    <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php 
                            $ctr++;
                        }
                    }else{
                    ?>  
                    <div class='alert alert-danger'>
                        <span>There were no timer invitations yet.</span>
                    </div>
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>