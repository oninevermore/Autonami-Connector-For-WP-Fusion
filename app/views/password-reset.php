<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-row-fluid bg-white" id="kt_login">
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 ml-auto mr-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center mt-6 mt-lg-0">
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->
                    
                    <form class="form" method="post"  novalidate="novalidate"  action="<?=REAL_URL?>/password-reset/update">
                        <!--begin::Title-->
                        <div class="pt-lg-40 mt-lg-10 pb-15">
                            <h3 class="font-weight-bolder text-dark display4">Password Reset </h3>
                            <span class="text-muted font-size-h5">Enter your new password</span>
                        </div>
                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <?php if(isset($model->error_message)){ ?>
                        <div class='alert alert-danger text-center'>
                            <?=$model->error_message?>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="New password" name="password" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-10">
                            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Submit</button>
                            <input type='hidden' name='request_id' value='<?=$model->request_id?>'/>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                
            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <div class="d-flex justify-content-lg-start justify-content-center flex-column-fluid align-items-end pb-2 pt-lg-0">
                &copy; Copyright 2020 - All Rights Reserved.
            </div>
            <!--end::Content footer-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->