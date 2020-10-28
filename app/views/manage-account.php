<div class="example-preview">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home">
                <span class="nav-icon">
                    <i class="fas fa-user-edit"></i>
                </span>
                <span class="nav-text">Account</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile">
                <span class="nav-icon">
                    <i class="flaticon-stopwatch"></i>
                </span>
                <span class="nav-text">Shared Timers</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form  action="<?=REAL_URL?>/manage-account/save" method="post">
                <div class="form-group">
                    <h3 class="font-weight-bolder text-dark display5">Account Info</h3>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Email:</label>
                        <input class="form-control" disabled type="text" value="<?=$model->email?>" />
                    </div>   
                    <div class="col-md-4">
                        <label>Firstname:</label>
                        <input class="form-control" type="text" value="<?=$model->first_name?>" placeholder="Firstname" name="first_name"/>
                    </div>  
                    <div class="col-md-4">
                        <label>Lastname:</label>
                        <input class="form-control" type="text" value="<?=$model->last_name?>" placeholder="Firstname" name="last_name"/>
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
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Tab content 2</div>
    </div>
</div>