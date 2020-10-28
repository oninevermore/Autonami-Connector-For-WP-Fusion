/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var pasteData = "";
var initEmailTags = function() {
        // Init autocompletes
    var allUsersVal = $("#allUsers").val();
    var allUsers = JSON.parse(allUsersVal);
    var toEl = document.getElementById('email_addresses');
    var tagifyTo = new Tagify(toEl, {
        delimiters: ", ", // add new tags when a comma or a space character is entered
        maxTags: 10,
        blacklist: ["fuck", "shit", "pussy"],
        keepInvalidTags: true, // do not remove invalid tags (but keep them marked as invalid)
        whitelist: allUsers,
        templates: {
            dropdownItem : function(tagData){
                try {
                    var html = '';

                    html += '<div class="tagify__dropdown__item">';
                    html += '   <div class="d-flex align-items-center">';
                    html += '       <span class="symbol sumbol-' + (tagData.initialsState ? tagData.initialsState : '') + ' mr-2">';
                    html += '           <span class="symbol-label" style="background-image: url(\''+ (tagData.pic ? tagData.pic : '') + '\')">' + (tagData.initials ? tagData.initials : '') + '</span>';
                    html += '       </span>';
                    html += '       <div class="d-flex flex-column">';
                    html += '           <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">'+ (tagData.value ? tagData.value : '') + '</a>';
                    html += '           <span class="text-muted font-weight-bold">' + (tagData.email ? tagData.email : '') + '</span>';
                    html += '       </div>';
                    html += '   </div>';
                    html += '</div>';
                    
                    return html;
                } catch (err) {}
            }
        },
        transformTag: function(tagData) {
            tagData.class = 'tagify__tag tagify__tag--primary';
        },
        dropdown : {
            classname : "color-blue",
            enabled   : 1,
            maxItems  : 5
        }
    });
}

var initTimePicker = function(obj){
    obj.timepicker({
        secondStep:1,
        minuteStep: 1,
        defaultTime: '',
        showSeconds: true,
        showMeridian: false,
        snapToStep: true
    });
}

var bindAddTaskInterval = function(){
    $("#addTaskInterval").click(function () {
        var clone = $(".intervals .card:first").clone();
        $(".remove-int-task", clone).removeClass("disabled").click(function () {
            $(this).parents(".card").remove();
        });
        initTimePicker($(".duration", clone));
        $(".intervals .card:last").after(clone);
        $(".task_name", clone).val("").focus();
        $("textarea", clone).val("")
        bindDuplicateTaskInterval($(".duplicate-int-task", clone));
        bindIntervalChk($(".chk-intvl", clone));
        bindCopy($(".copy-int-task", clone));
    }); 
};

var bindDuplicateMultipleTaskInterval = function(){
    $(".duplicate-task-m").unbind("click").click(function () {
        var chkbxs = $("input.chk-intvl:checked");
        
        $.each(chkbxs, function(i, o){
            var parent = $(o).parents(".card");
            var clone = parent.clone();
            $(".remove-int-task", clone).removeClass("disabled").click(function () {
                $(this).parents(".card").remove();  
            });
            initTimePicker($(".duration", clone));
            parent.after(clone);
            $(".task_name", clone).focus();
            bindDuplicateTaskInterval($(".duplicate-int-task", clone));
            bindIntervalChk($(".chk-intvl", clone));
            bindCopy($(".copy-int-task", clone));
        })
        $("input.chk-intvl:checked").prop('checked', false);
        $(".task-btn").attr("disabled", "disabled");
    }); 
};

var bindDeleteMultipleTaskInterval = function(){
    $(".deletetask-m").click(function () {
        var chkbxs = $("input.chk-intvl:checked");
        
        $.each(chkbxs, function(i, o){
            var parent = $(o).parents(".card");
            if(parent.is(".card:first")){
                $(".task_name", parent).val("").focus();
                $("textarea", parent).val("")
            }else{
                parent.remove();
            }
        })
        $("input.chk-intvl:checked").prop('checked', false);
        $(".task-btn").attr("disabled", "disabled");
    }); 
};


var bindDuplicateTaskInterval = function(obj){
    if(obj === undefined){
        obj = $(".duplicate-int-task");
    }
    obj.click(function () {
        var parent = $(this).parents(".card");
        var clone = parent.clone();
        $(".remove-int-task", clone).removeClass("disabled").click(function () {
            $(this).parents(".card").remove();  
        });
        initTimePicker($(".duration", clone));
        parent.after(clone);
        $(".task_name", clone).focus();
        bindDuplicateTaskInterval($(".duplicate-int-task", clone));
        bindIntervalChk($(".chk-intvl", clone));
        bindCopy($(".copy-int-task", clone));
    }); 
};

var editTaskInterval = function(isSubTimer){
    var obj = isSubTimer === true ? "#modalNewTimer .edit-timer" : "#modalItems .edit-timer";
    $(obj).unbind("click").click(function () {
        var id = $(this).data("id");
        var data = {
            id:id,
            is_subtimer:isSubTimer === false ? 0 : 1
        };
        $.get(real_url + "/task", data, function (result) {
            
            //var tmrType = $("#modalNewTimer input[name=timer_type]").val();
            var tmrBody = isSubTimer === false ? "#tmrBody" : "#subTmrBody"
            $(tmrBody).html(result);
            if(isSubTimer == false){
                var timerSetName = $("#modalNewTimer input[name=timer_set_name]").val();
                editTaskInterval(true);
                bindDeleteTimer(true);
                bindNewTimer(".btnNewSubTimer", true);
                $("#modalNewTimer .tmr-typ-name").text("Edit Timer - " + timerSetName);
            }else{
                var subTimerSetName = $("#modalNewSubTimer input[name=timer_set_name]").val();
                $("#modalNewSubTimer .tmr-typ-name").text("Edit Sub Timer - " + subTimerSetName);
                bindCloseModal();
            }
            var modalBody = isSubTimer === false ? "#modalNewTimer" : "#modalNewSubTimer"
            $(modalBody).modal("show");
            initTimePicker($(".duration"));
            
            
            $(".remove-int-task").unbind().click(function () {
                $(this).parents(".card").remove();
            });
            
            
            
            //}else{
            //    $("#modalNewSubTimer .tmr-typ-name").text(_obj.text());
            bindAddTaskInterval();
            bindSaveSubTaskInterval();
            bindDuplicateTaskInterval();
            bindDuplicateMultipleTaskInterval();
            bindDeleteMultipleTaskInterval();
            bindIntervalChk();
            bindCopy();
            bindOptional();
        });
    });
}

var bindIntervalChk = function(obj){
    if(obj === undefined){
        obj = $(".chk-intvl");
    }
    obj.change(function(){
        var chkbxs = $("input.chk-intvl:checked");
        if(chkbxs.length > 0){
            $(".task-btn").removeAttr("disabled");
        }else{
            $(".task-btn").attr("disabled", "disabled");
        }
    });
}

var chkPasteData = function(){
   if(pasteData === ""){
        $(".paste").attr("disabled", "disabled");
    }else{
        $(".paste").removeAttr("disabled");
    } 
}

var bindCopy = function(obj){
    if(obj === undefined){
        obj = $(".copy-int-task");
    }
    obj.click(function () {
        var parent = $(this).parents(".card");
        pasteData = parent.clone();
        Swal.fire(
            "Copied!",
            "Your Timer details has been copied.",
            "success"
        );
        $(".paste").removeAttr("disabled");
    }); 
}

var bindPaste = function(){
    $(".paste").click(function () {
        $(".intervals .card:last").after(pasteData);
        initTimePicker($(".duration", pasteData));
        $(".remove-int-task", pasteData).removeClass("disabled").click(function () {
            $(this).parents(".card").remove();  
        });
        $(".task_name", pasteData).focus();
        bindDuplicateTaskInterval($(".duplicate-int-task", pasteData));
        bindIntervalChk($(".chk-intvl", pasteData));
        bindCopy($(".copy-int-task", pasteData));
        pasteData = pasteData.clone();
    });
}

var showLoader = function(){
    $('.tooltip').remove();
    KTApp.blockPage({
        overlayColor: '#000000',
        state: 'danger',
        opacity: 0.6,
        message: 'Please wait...'
    });
};

var hideLoader = function(){
    KTApp.unblockPage();
};

var bindOptional = function(){
    $(".chk-optional").change(function(){
        var chk = $(this);
        var parent = chk.parents(".card");
        if(chk.is(":checked")){
            $(".card-body input", parent).removeAttr("disabled");
        }else{
            $(".card-body input", parent).attr("disabled", "disabled");
        }
    });
};

var bindDeleteTimer = function(isSubTimer){
    $(".deletetimer").unbind("click").click(function () {
        var btn = $(this);
        var id = btn.data("id");
        var data;
        
        if(id === undefined){
            if(isSubTimer === true){
                data = $("#modalItems .chk input").serialize();
            }else{
                data = $("#modalNewSubTimer .chk input").serialize();
            }
            
        }else{
            data = {id:id};
        }
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.get(real_url + "/task/" + (isSubTimer === true ? "delete_sub_timer" : "delete"),data, function (response) {
                    if(response.result == "success"){
                        Swal.fire(
                            "Deleted!",
                            "Your Timer Set has been deleted.",
                            "success"
                        );
                        if(id === undefined){
                            $(".chk input:checked").parents(".item-panel").remove();
                        }else{
                            btn.parents(".item-panel").remove();
                        }
                    }
                });
            }
        });
    }); 
}

var bindDuplicateTimer = function(){
    $('.duplicate').unbind("click").click(function () {
        showLoader();
        var id = $(this).data("id");
        var data;
        
        if(id === undefined){
            data = $(".chk input").serialize();
        }else{
            data = {id:id};
        }
        $.post(real_url + "/task/duplicate", data, function (response) {
            if(response != ""){
                $("#task-body").html(response);
                hideLoader();
                Swal.fire(
                    "Duplicated!",
                    "Timer set duplicated successfully.",
                    "success"
                );
                bindTimerButtons();
                bindRun();   
                $('[data-toggle="tooltip"]').tooltip();
                $(".tmr-btn").attr("disabled", "disabled");
            }
        });
    });
}

var bindTimerButtons = function(){
    $(".share").unbind("click").click(function () {
        var id = $(this).data("id");
        
        if(id === undefined){
            id = $(".chk input:checked").map(function () {
                return this.value;
            }).get().join();
        }
        $("#hd_task_id").val(id);
        $("#modalShare").modal("show");
    }); 

    bindDeleteTimer();
    
    bindDuplicateTimer();
    
    $(".chk-tmr input").change(function(){
        var chkbxs = $(".chk-tmr input:checked");
        if(chkbxs.length > 0){
            $(".tmr-btn").removeAttr("disabled");
        }else{
            $(".tmr-btn").attr("disabled", "disabled");
        }
    });
    
    editTaskInterval(false);
};

var bindCloseModal = function(){
    $("#modalNewSubTimer .close, #modalNewSubTimer .btn-close").unbind().click(function(){
        setTimeout(function(){
            $("body").addClass("modal-open");
        },500);
    });
}

var bindNewTimer = function(obj, isSubTImer){
    $(obj).click(function () {
        var _obj = $(this);
        var url = _obj.attr("href");
        showLoader();
        $.get(url,  function (result) {
            hideLoader();
            var tmrBody = isSubTImer === false ? "#tmrBody" : "#subTmrBody"
            $(tmrBody).html(result);
            initTimePicker($(".duration"));
            var modalBody = isSubTImer === false ? "#modalNewTimer" : "#modalNewSubTimer"
            $(modalBody).modal("show");
            if(isSubTImer === false){
                bindNewTimer(".btnNewSubTimer", true);
                $("#modalNewTimer .tmr-typ-name").text("New " + _obj.text());
            }else{
                $("#modalNewSubTimer .tmr-typ-name").text("New Sub Timer - " + _obj.text());
                bindSaveSubTaskInterval();
                bindCloseModal();
            }
            $("body").addClass("modal-open");
            bindAddTaskInterval();
            bindDuplicateTaskInterval();
            bindDuplicateMultipleTaskInterval();
            bindDeleteMultipleTaskInterval();
            bindIntervalChk();
            bindCopy();
            chkPasteData();
            bindOptional();
        });
        return false;
    });
}

var toggleFullScreen = function() {
    var elem = document.body;
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
};

var bindSaveSubTaskInterval = function(){
    $("#btnSaveSubTaskInterval").unbind().click(function () {
        var frm = $("#frmSubTask");
        var data = frm.serialize();
        var action = frm.attr("action");
        var id = $("#modalNewSubTimer input[name=id]").val();
        showLoader();
        $.post(action, data, function (response) {
            if(response != ""){
                if(id > 0){
                    $("div.d-flex[data-id=" + id + "]").replaceWith(response)
                }else{
                    $("#sub-timer-list .alert").remove();
                    $("#sub-timer-list").append(response); 
                }
                editTaskInterval(true);
                bindDeleteTimer(true);
                hideLoader();
                Swal.fire(
                    id > 0 ? "Updated": "Added!",
                    "Sub Timer set " + (id > 0 ? "updated": "added!") + " successfully.",
                    "success"
                );
                $("#modalNewSubTimer").modal("hide");
                setTimeout(function(){
                    $("body").addClass("modal-open");
                },500);
            }
        });
    });
};


        
$("document").ready(
    function () {
        bindTimerButtons();
        $(".btnTimerSets").click(function () {
            $("#modalItems").modal("show");
        }); 
        
        bindNewTimer(".btnNewTimer", false);
        
        $("#btnSaveTaskInterval").click(function () {
            $("#frmTask").submit();
        });
        
        $("#btnShareNow").click(function () {
            $("#frmShare").submit();
        });
        bindPaste();
        initEmailTags();
    }
);
