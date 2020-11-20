var bindSaveAccount = function(){
    $(".save-account").unbind().click(function () {
        var form = $(this).closest('form');
        var action = form.attr("action");
        showLoader();
        form.ajaxSubmit({
            url: action,
            success: function(response, status, xhr, $form) {
                hideLoader();
                if(response.result == "success"){
                   swal.fire({
                        text: response.success_message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function() {
                        
                    });
                }else{
                    swal.fire({
                        text: response.error_message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function() {
                        
                    });
                }
            }
        });
    }); 
};

var bindRemoveShare = function(){
    $(".remove-share").unbind().click(function(){
        var btn = $(this);
        var id = btn.data("share_id");
        var data = {id:id};
        Swal.fire({
            title: "Are you sure?",
            text: "This user will be remove from this timer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, remove it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                showLoader();
                $.post(real_url + "/manage-account/remove-share", data, function (response) {
                    hideLoader();
                    if(response.result == "success"){
                        Swal.fire(
                            "Remove!",
                            "The user was remove from this timer.",
                            "success"
                        );
                        var btnParent = btn.parents(".user-pnl");
                        var pnlParent = btnParent.parents(".card");
                        btnParent.remove();
                        if(pnlParent.has("div.user-pnl").length <= 0){
                            pnlParent.remove();
                        }
                    }
                });
            }
        });
    });
};

var bindRemoveShare = function(){
    $(".remove-share").unbind().click(function(){
        var btn = $(this);
        var id = btn.data("share_id");
        var data = {id:id};
        Swal.fire({
            title: "Are you sure?",
            text: "This user will be remove from this timer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, remove it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                showLoader();
                $.post(real_url + "/manage-account/remove-share", data, function (response) {
                    hideLoader();
                    if(response.result == "success"){
                        Swal.fire(
                            "Remove!",
                            "The user was remove from this timer.",
                            "success"
                        );
                        var btnParent = btn.parents(".user-pnl");
                        var pnlParent = btnParent.parents(".card");
                        btnParent.remove();
                        if(pnlParent.has("div.user-pnl").length <= 0){
                            pnlParent.remove();
                        }
                    }
                });
            }
        });
    });
}

var bindRejectInvitation = function(){
    $(".reject-invitation").unbind().click(function(){
        var btn = $(this);
        var id = btn.data("share_id");
        var data = {id:id};
        Swal.fire({
            title: "Are you sure?",
            text: "This will reject timer invitation from this user.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, reject it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                showLoader();
                $.post(real_url + "/manage-account/reject-invitation", data, function (response) {
                    hideLoader();
                    if(response.result == "success"){
                        Swal.fire(
                            "Rejected!",
                            "You have rejected an invitation from this user.",
                            "success"
                        );
                        var btnParent = btn.parents(".user-pnl");
                        var pnlParent = btnParent.parents(".card");
                        btnParent.remove();
                        if(pnlParent.has("div.user-pnl").length <= 0){
                            pnlParent.remove();
                        }
                    }
                });
            }
        });
    });
};

var bindApprovedInvitation = function(){
    $(".approved-invitation").unbind().click(function(){
        var btn = $(this);
        var id = btn.data("share_id");
        var data = {id:id};
        Swal.fire({
            title: "Are you sure?",
            text: "This will approved timer invitation from this user.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, approve it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                showLoader();
                $.post(real_url + "/manage-account/approved-invitation", data, function (response) {
                    hideLoader();
                    if(response.result == "success"){
                        Swal.fire(
                            "Approved!",
                            "You have approved an invitation from this user.",
                            "success"
                        );
                        var btnParent = btn.parents(".user-pnl");
                        var pnlParent = btnParent.parents(".card");
                        btnParent.remove();
                        if(pnlParent.has("div.user-pnl").length <= 0){
                            pnlParent.remove();
                        }
                    }
                });
            }
        });
    });
};

var bindManageAccount = function(){
    $(".btnManageAccount").click(function () {
        var url = real_url + "/manage-account";
        showLoader();
        $.get(url,  function (result) {
            hideLoader();
            $("#manageAccountBody").html(result);
            $("#modalManageAccount").modal("show");
            bindSaveAccount();
            bindRemoveShare();
            bindApprovedInvitation();
            bindRejectInvitation();
        });
        return false;
    });
};
$("document").ready(
    function () {
        bindManageAccount();
    }
);