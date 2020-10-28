var bindSaveAccount = function(){
    $(".save-account").click(function () {
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

var bindManageAccount = function(){
    $(".btnManageAccount").click(function () {
        var url = real_url + "/manage-account";
        showLoader();
        $.get(url,  function (result) {
            hideLoader();
            $("#manageAccountBody").html(result);
            $("#modalManageAccount").modal("show");
            bindSaveAccount();
        });
        return false;
    });
};
$("document").ready(
    function () {
        bindManageAccount();
    }
);