"use strict";

// Class Definition
var KTLoginGeneral = function() {
    var _login;

    var _showForm = function(form) {
        var cls = 'login-' + form + '-on';
        var form = 'kt_login_' + form + '_form';

        _login.removeClass('login-forgot-on');
        _login.removeClass('login-signin-on');
        _login.removeClass('login-signup-on');

        _login.addClass(cls);

        KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
    }

    var _handleSignInForm = function() {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            KTUtil.getById('kt_login_signin_form'),
            {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#kt_login_signin_submit').on('click', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var action = form.attr("action");
            validation.validate().then(function(status) {
                if (status == 'Valid') {
                    form.ajaxSubmit({
                        url: action,
                        success: function(response, status, xhr, $form) {
                            if(response.result == "success"){
                               document.location.href = response.return_url;
                            }else{
                                swal.fire({
                                    text: response.error_message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function() {
                                    KTUtil.scrollTop();
                                });
                            }
                        }
                    });
                } else {
                    swal.fire({
                        text: "Please correct each fields containing errors and try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function() {
                        KTUtil.scrollTop();
                    });
                }
            });
        });

        // Handle forgot button
        $('#kt_login_forgot').on('click', function (e) {
            e.preventDefault();
            _showForm('forgot');
        });

        // Handle signup
        $('#kt_login_signup').on('click', function (e) {
            e.preventDefault();
            _showForm('signup');
        });
    }

    var _handleSignUpForm = function(e) {
        var validation;
        var form = KTUtil.getById('kt_login_signup_form');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    fname: {
                        validators: {
                            notEmpty: {
                                message: 'Firstname is required'
                            }
                        }
                    },
                    lname: {
                        validators: {
                            notEmpty: {
                                message: 'Lastname is required'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    },
                    cpassword: {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#kt_login_signup_submit').on('click', function (e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');
            var action = form.attr("action");

            validation.validate().then(function(status) {
                if (status == 'Valid') {
                    $('#kt_login_signup_cancel').hide();
                    btn.addClass('spinner spinner-right pr-12 spinner-sm spinner-white').text('Inserting data to database...');
                    form.ajaxSubmit({
                        url: action,
                        success: function(response, status, xhr, $form) {
                            if(response.result == "success"){
                                //similate 2s delay
                               setTimeout(function() {
                                   btn.removeClass('spinner spinner-right pr-12 spinner-sm spinner-white').text('Success!');

                                   setTimeout(function(){
                                       form.clearForm();
                                       form.resetForm();
                                       location.reload();
                                   }, 1500);

                               }, 2000);
                            }else{
                                swal.fire({
                                    text: response.error_message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function() {
                                    KTUtil.scrollTop();
                                    btn.removeClass('spinner spinner-right pr-12 spinner-sm spinner-white').text('Submit!');
                                    $('#kt_login_signup_cancel').show();
                                });
                            }
                        }
                    });
                } else {
                    swal.fire({
                        text: "Please correct each fields containing errors and try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function() {
                        KTUtil.scrollTop();
                    });
                }
            });
        });

        // Handle cancel button
        $('#kt_login_signup_cancel').on('click', function (e) {
            e.preventDefault();

            _showForm('signin');
        });
    }

    var _handleForgotForm = function(e) {
        var validation;
        var form = $(this).closest('form');
        var action = form.attr("action");
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            KTUtil.getById('kt_login_forgot_form'),
            {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        // Handle submit button
        $('#kt_login_forgot_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
                if (status == 'Valid') {
                    form.ajaxSubmit({
                        url: action,
                        success: function(response, status, xhr, $form) {
                            if(response.result == "success"){
                                //similate 2s delay
                               setTimeout(function() {
                                   btn.removeClass('spinner spinner-right pr-12 spinner-sm spinner-white').text('Success!');

                                   setTimeout(function(){
                                       form.clearForm();
                                       form.resetForm();
                                       location.reload();
                                   }, 1500);

                               }, 2000);
                            }else{
                                swal.fire({
                                    text: response.error_message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function() {
                                    KTUtil.scrollTop();
                                    btn.removeClass('spinner spinner-right pr-12 spinner-sm spinner-white').text('Submit!');
                                    $('#kt_login_signup_cancel').show();
                                });
                            }
                        }
                    });
                    KTUtil.scrollTop();
                } else {
                    swal.fire({
                        text: "Please correct each fields containing errors and try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function() {
                        KTUtil.scrollTop();
                    });
                }
            });
        });

        // Handle cancel button
        $('#kt_login_forgot_cancel').on('click', function (e) {
            e.preventDefault();

            _showForm('signin');
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            _login = $('#kt_login');

            _handleSignInForm();
            _handleSignUpForm();
            _handleForgotForm();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLoginGeneral.init();
});
