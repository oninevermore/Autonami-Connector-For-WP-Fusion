/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var synth = window.speechSynthesis;
const ps = new PerfectScrollbar('#items',{
    suppressScrollX : true
});
var willCheckUpdate = true;
const psModal = new PerfectScrollbar('.modal-scroll',{
    suppressScrollX : true
});
var timer;
var timerChecker;
var ctimer;
var queues = [];
var nextQueueIndex = 0;
//var currentQueue = queues[currentQueueIndex];
//var currentQueueSplit = currentQueue.split(":");

var hours = 0;
var minutes = 0;
var seconds = 0;

var totalHours = 0;
var totalMinutes = 0;
var totalSeconds = 0;

var elapsedHours = 0;
var elapsedMinutes = 0;
var elapsedSeconds = 0;

var realTotalSeconds = 0;
var instructionText = "";
var starttime = new Date();

var getTotalSeconds = function(index){
    var tSeconds = 0;
    if(queues.length > 0){
        for (i = 0; i < queues.length; i++) {
            if(index !== undefined){
                if(index === i){
                    return queues[i].total_seconds;
                }
            }else{
                tSeconds += queues[i].total_seconds;
            }
        }
    }
    return tSeconds;
};

var setQueueItems = function(){
    var html = "";
    if(queues.length > 0){
        realTotalSeconds = 0;
        for (i = 0; i < queues.length; i++) {
            html += '<div data-index="' + i + '" class="task-item" id="task-item-' + i + '">' +
                        '<div class="alert text-center" style="background-color:' + queues[i].color + '; border:1px solid ' + queues[i].t_color + '" role="alert">' +
                            '<h1 style="color:' + queues[i].t_color + '">' + queues[i].title + '</h1>' +
                            '<h3 style="color:' + queues[i].t_color + ';opacity: .6">' + queues[i].time + '</h3>' +
                        '</div>' +
                    '</div>';
            realTotalSeconds += queues[i].total_seconds;
        }
    }
    $("#items").html(html);
    var height = $(".task-item:first").height() * 2;
    var extra = '<div style="height:' + height + 'px;"></div>';
    $(".task-item:last").after(extra);
};

var setQueueColor = function(){
    var current_item = $("#task-item-" + (nextQueueIndex));
    if(current_item !== undefined){
        $('#items').animate({
            scrollTop: ($("#task-item-" + (nextQueueIndex)).height() + 11) * nextQueueIndex   
        }, 1000);
    }
    $("#queue").html((nextQueueIndex + 1) + "/" + (queues.length));
    $("body").css("background-color", queues[nextQueueIndex].color);
    $("#timerGrp h1, #timerGrp h2, #timerGrp h3").css("color", queues[nextQueueIndex].t_color);
};

var setQueueTimer = function(){
    var currentQueue = queues[nextQueueIndex].time;
    instructionText = queues[nextQueueIndex].instruction;
    setQueueColor();
    var currentQueueSplit = currentQueue.split(":");

    hours = parseInt(currentQueueSplit[0]);
    minutes = parseInt(currentQueueSplit[1]);
    seconds = parseInt(currentQueueSplit[2]);
    if(synth.speaking){
        synth.cancel();
    }
    speak(instructionText);
    nextQueueIndex = nextQueueIndex + 1;
    //runTimer();
};

var checkUpdate = function(){
    var timerChecker = setInterval(function () {
        if(willCheckUpdate){
            //console.log(elapsedSeconds);
            $.get(real_url + "/home/running", function (result) {
                if(willCheckUpdate){
                    if(result.result === "success"){
                        if(result.current_timer === null || result.current_timer === undefined){
                            if($(".timer-control").is(":visible")){
                                stopTimer();
                                $("#modalItems").modal("show");
                                $(".btnlist").show("fast");
                                $(".timer-control").hide("fast");
                            }
                        }else{
                            if(ctimer === null || ctimer === undefined){
                                $.get(real_url + "/task/details", {id:result.current_timer.task_id}, function (result) {
                                    queues = result;
                                    clearInterval(timer);
                                    openTimer();
                                    if(ctimer.status === "RUNNING"){
                                        var elapsed = ctimer.time_now -  ctimer.date_started;
                                        continueTimer(elapsed);
                                    }
                                });
                                ctimer = result.current_timer;
                            }else{
                               if(result.current_timer.task_id === ctimer.task_id){
                                    if(result.current_timer.last_time_updated !== ctimer.last_time_updated){
                                        if(result.current_timer.status === "DONE"){

                                        }else{
                                            ctimer = result.current_timer;
                                            clearInterval(timer);
                                            var elapsed = ctimer.time_now -  ctimer.date_started;
                                            continueTimer(elapsed);
                                        }
                                    }
                               }else{

                               } 
                            }
                        }
                    }
                }
            });
        }
            
    }, 1000);
};

var displayLabels = function(){
    $("#maintimer").html((hours > 9 ? "" : "0") + hours + ":" + (minutes > 9 ? "" : "0") + minutes + ":" + (seconds > 9 ? "" : "0") + seconds);
    $("#remaining").html((totalHours > 9 ? "" : "0") + totalHours + ":" + (totalMinutes > 9 ? "" : "0") + totalMinutes + ":" + (totalSeconds > 9 ? "" : "0") + totalSeconds);
    $("#elapsed").html((elapsedHours > 9 ? "" : "0") + elapsedHours + ":" + (elapsedMinutes > 9 ? "" : "0") + elapsedMinutes + ":" + (elapsedSeconds > 9 ? "" : "0") + elapsedSeconds);
}



var runTimer = function(){
    var btn = $(".pause-play");
    btn.removeClass("btn-success").addClass("btn-warning");
    $("i", btn).removeClass("fa-play-circle").addClass("fa-pause-circle");
    var totalTimeInSeconds = getTotalSeconds();
    //toggleFullScreen();
    timer = setInterval(function () {
        var now = Date.parse(new Date().toUTCString());
        var strtym = starttime.getTime();
        var remaining =  ((strtym / 1000) + totalTimeInSeconds) - (now / 1000);
        var diff = (now - strtym) / 1000;
        computeRemaining(remaining + 1);
        computeElapsed(diff);
        
        
        
        
        var tSeconds = 0;
        if(queues.length > 0){
            var currentIntervalTotalTime = 0;
            for (i = 0; i < queues.length; i++) {
                tSeconds += queues[i].total_seconds;
                if(tSeconds >  Math.round(diff)){
                    //console.log(tSeconds + "==" +  Math.floor(diff));
                    currentIntervalTotalTime = tSeconds;
                    break;
                }
            }
            
            var remainingCurrent = ((strtym / 1000) + currentIntervalTotalTime) - (now / 1000);
            console.log(Math.round(remainingCurrent) + "==" + remainingCurrent);
            if(remainingCurrent >= 0){
                if(remainingCurrent > 3600){
                    hours = Math.floor(remainingCurrent / 3600);
                    var rElapsedHour = remainingCurrent - (hours * 3600);
                    if(rElapsedHour >= 60){
                        minutes =  Math.floor(rElapsedHour / 60);
                        seconds = rElapsedHour - (minutes * 60);
                    }else{
                        minutes = 0;
                        seconds = rElapsedHour;
                    }
                }else{
                    hours = 0;
                    if(remainingCurrent >= 60){
                        minutes =  Math.floor(remainingCurrent / 60);
                        seconds = Math.floor(remainingCurrent - (minutes * 60));
                    }else{
                        minutes = 0;
                        seconds = Math.floor(remainingCurrent);
                    }
                }
            }
            
        }
        if(diff > (tSeconds + 1)){
            console.log(tSeconds);
            clearInterval(timer);
        }else{
            displayLabels();
        }
        
        
//        if(seconds > 0){
//            seconds = seconds - 1;
//            
//            if(seconds <= 4 && minutes <= 0 && hours <= 0){
//                beep();
//            }
//        }else{
//            if(minutes > 0){
//                minutes = minutes - 1;
//                seconds = 59;
//            }else{
//                if(hours > 0){
//                    hours = hours - 1;
//                    minutes = 59;
//                    seconds = 59;
//                }else{
//                    //clearInterval(timer);
//                    if(queues.length > nextQueueIndex){
//                        setQueueTimer();
//                        //runTimer();
//                        computeTotalHours();
//                        var rTotalSeconds = totalHours * 60 * 60;
//                        rTotalSeconds += totalMinutes * 60;
//                        rTotalSeconds += totalSeconds;
//                        var elapsed = realTotalSeconds - rTotalSeconds + 1;
//                        computeElapsedBySeconds(elapsed);
//                        return;
//                    }else{
//                        clearInterval(timer);
//                        //$(".task-item:hidden").show("fast");
//                    }
//                }
//            }
//        }
        //computeRemaining();
        //computeElapsed();
        

    }, 1000);

};

var stopTimer = function(preserve = false){
    clearInterval(timer);
    $("#maintimer").html("00:00:00");
    $("#queue").html("0/0");
    $("#remaining").html("00:00:00");
    $("#elapsed").html("00:00:00");
    $("#items").html("");
    
    nextQueueIndex = 0;
    hours = 0;
    minutes = 0;
    seconds = 0;

    totalHours = 0;
    totalMinutes = 0;
    totalSeconds = 0;

    elapsedHours = 0;
    elapsedMinutes = 0;
    elapsedSeconds = 0;
    
    if(!preserve){
        ctimer = null;
        queues = [];
    }
    synth.cancel();
};

var computeElapsed = function(diff){
    if(diff > 3600){
        elapsedHours = Math.floor(diff / 3600);
        var rElapsedHour = diff - (elapsedHours * 3600);
        if(rElapsedHour >= 60){
            elapsedMinutes =  Math.floor(rElapsedHour / 60);
            elapsedSeconds = rElapsedHour - (elapsedMinutes * 60);
        }else{
            elapsedMinutes = 0;
            elapsedSeconds = rElapsedHour;
        }
    }else{
        elapsedHours = 0;
        if(diff >= 60){
            elapsedMinutes =  Math.floor(diff / 60);
            elapsedSeconds = Math.floor(diff - (elapsedMinutes * 60));
        }else{
            elapsedMinutes = 0;
            elapsedSeconds = Math.floor(diff);
        }
    }
    
//    if((elapsedSeconds + 1) < 60){
//        elapsedSeconds = elapsedSeconds + 1;
//    }else{
//        if((elapsedMinutes + 1) <= 60){
//            elapsedMinutes = elapsedMinutes + 1;
//            elapsedSeconds = 0;
//        }else{
//            if((elapsedHours + 1) < 60){
//                elapsedHours = elapsedHours + 1;
//                elapsedMinutes = elapsedMinutes + 1;
//                elapsedSeconds = 0;
//            }else{
//
//            }
//        }
//    }
};

var computeRemaining = function(remaining){
    if(remaining > 3600){
        totalHours = Math.floor(remaining / 3600);
        var rElapsedHour = remaining - (totalHours * 3600);
        if(rElapsedHour >= 60){
            totalMinutes =  Math.floor(rElapsedHour / 60);
            totalSeconds = rElapsedHour - (totalMinutes * 60);
        }else{
            totalMinutes = 0;
            totalSeconds = rElapsedHour;
        }
    }else{
        totalHours = 0;
        if(remaining >= 60){
            totalMinutes =  Math.floor(remaining / 60);
            totalSeconds = Math.floor(remaining - (totalMinutes * 60));
        }else{
            totalMinutes = 0;
            totalSeconds = Math.floor(remaining);
        }
    }
    
//    if(totalSeconds > 0){
//        totalSeconds = totalSeconds - 1;
//    }else{
//        if(totalMinutes > 0){
//            totalMinutes = totalMinutes - 1;
//            totalSeconds = 59;
//        }else{
//            if(totalHours > 0){
//                totalHours = totalHours - 1;
//                totalMinutes = 59;
//                totalSeconds = 59;
//            }else{
//
//            }
//        }
//    }
};

var computeTotalHours = function(){
    totalHours = 0;
    totalMinutes = 0;
    totalSeconds = 0;
    if(queues.length > 0){
        
        for (i = nextQueueIndex - 1; i < queues.length; i++) {
            var queue = queues[i].time;
            var queueSplit = queue.split(":");

            totalHours = totalHours + parseInt(queueSplit[0]);
            totalMinutes += parseInt(queueSplit[1]);
            totalSeconds += parseInt(queueSplit[2]);
        }
        
        if(totalSeconds >= 60){
            var remainingSeconds = Math.floor(totalSeconds / 60);
            totalSeconds = totalSeconds - (remainingSeconds * 60);
            totalMinutes = totalMinutes + remainingSeconds;
        }
        if(totalMinutes >= 60){
            var remainingMinutes = Math.floor(totalMinutes / 60);
            totalMinutes = totalMinutes - (remainingMinutes * 60);
            totalHours = totalHours + remainingMinutes;
        }
        
        $("#remaining").html((totalHours > 9 ? "" : "0") + totalHours + ":" + (totalMinutes > 9 ? "" : "0") + totalMinutes + ":" + (totalSeconds > 9 ? "" : "0") + totalSeconds);
    }
};

var  beep = function() {
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
};

var updateItemHeight = function(){
    var wHeight = $(window).height();
    var tHeight = $("#timerGrp").height();
    $("#items").height(wHeight - tHeight - 1);
    if(ps !== undefined){
        ps.update();
    }
    
    $(".modal-scroll").height(wHeight - (wHeight * .4));
};

var computeElapsedBySeconds = function(elapsed){
    if(elapsed > 3600){
        elapsedHours = Math.floor(elapsed / 3600);
        var rElapsedHour = elapsed - (elapsedHours * 3600);
        if(rElapsedHour >= 60){
            elapsedMinutes =  Math.floor(rElapsedHour / 60);
            elapsedSeconds = rElapsedHour - (elapsedMinutes * 60);
        }else{
            elapsedMinutes = 0;
            elapsedSeconds = rElapsedHour;
        }
    }else{
        elapsedHours = 0;
        if(elapsed >= 60){
            elapsedMinutes =  Math.floor(elapsed / 60);
            elapsedSeconds = elapsed - (elapsedMinutes * 60);
        }else{
            elapsedMinutes = 0;
            elapsedSeconds = elapsed;
        }
    }
};

var bindTaskItem = function(){
    $(".task-item").unbind().click(function () {
        alert("pasok");
        clearInterval(timer);
        nextQueueIndex = parseInt($(this).data("index"));
        setQueueTimer();
        runTimer();
        computeTotalHours();
        var rTotalSeconds = totalHours * 60 * 60;
        rTotalSeconds += totalMinutes * 60;
        rTotalSeconds += totalSeconds;
        var elapsed = realTotalSeconds - rTotalSeconds + 1;
        computeElapsedBySeconds(elapsed);
        setTimer(ctimer.id, ctimer.task_id, "RUNNING",
            function(){
                alert("running");
            }
        );
    });
};

var setTimer = function(id, task_id, status, callback){
    willCheckUpdate = false;
    var elapsed = (elapsedHours * 3600) + (elapsedMinutes * 60) + elapsedSeconds;
    var clientTimestamp = Date.parse(new Date().toUTCString()) / 1000;
    var data = {
        id : id,
        task_id : task_id,
        status : status,
        elapsed_time : elapsed
    };
    $.post(real_url + "/current-timer/set",data, function (response) {
        if(response.result === "success"){
            willCheckUpdate = true;
            if(status !== "DONE"){
                var serverTimestamp =  response.serverTimestamp;
                var serverClientRequestDiffTime = serverTimestamp - clientTimestamp;
                var nowTimeStamp = Date.parse(new Date().toUTCString()) / 1000;
                
                var serverClientResponseDiffTime = nowTimeStamp - serverTimestamp;
                var responseTime = (serverClientRequestDiffTime - nowTimeStamp + clientTimestamp - serverClientResponseDiffTime )/2;
                var serverTimeOffset = (serverClientResponseDiffTime - responseTime);
                starttime = new Date();
                starttime.setTime(starttime.getTime() + (serverTimeOffset * 1000));
                //alert(starttime);
                ctimer = response.data;
                if(callback !== undefined){
                    callback();
                }
            }
        }
    });
};

var openTimer = function(){
    nextQueueIndex = 0;
    hours = 0;
    minutes = 0;
    seconds = 0;

    totalHours = 0;
    totalMinutes = 0;
    totalSeconds = 0;

    elapsedHours = 0;
    elapsedMinutes = 0;
    elapsedSeconds = 0;
    
    setQueueItems();
    setQueueTimer();
    computeTotalHours();
    updateItemHeight();    
    $("#modalItems").modal("hide");
    $(".btnlist").hide("fast");
    $(".timer-control").show("fast");

    var btn = $(".pause-play");
    btn.removeClass("btn-warning").addClass("btn-success");
    $("i", btn).removeClass("fa-pause").addClass("fa-play-circle");
    bindTaskItem();
};

var getEnglishVoice = function(){
    var voices = synth.getVoices().sort(function (a, b) {
        const aname = a.name.toUpperCase(), bname = b.name.toUpperCase();
        if (aname < bname)
            return -1;
        else if (aname == bname)
            return 0;
        else
            return +1;
    });
    for(i = 0; i < voices.length ; i++) {
      if(voices[i].name === "Google US English") {
        return voices[i];
        break;
      }
    }
    return null;
}

var speak = function (tts) {
    try{
        if (tts === '' || tts === undefined) {
            return;
        }else{
            if (synth.speaking) {
                console.error('speechSynthesis.speaking');
                return;
            }
            var utterThis = new SpeechSynthesisUtterance(tts);
            utterThis.onend = function (event) {
                console.log('SpeechSynthesisUtterance.onend');
            }
            utterThis.onerror = function (event) {
                //console.error('SpeechSynthesisUtterance.onerror');
            }
            utterThis.voice = getEnglishVoice();
            utterThis.pitch = 1;
            utterThis.rate = 1;
            //synth.speak(utterThis);
        }
    }catch(err) {
        console.log(err.message);
    }
    
}

var continueTimer = function(elapsed){
    if(queues.length > 0){
        computeTotalHours();
        var rTotalSeconds = totalHours * 60 * 60;
        rTotalSeconds += totalMinutes * 60;
        rTotalSeconds += totalSeconds;
        
        //========================================================
        computeElapsedBySeconds(elapsed);
        
        //========================================================
        
        if(rTotalSeconds > elapsed){
            rTotalSeconds = rTotalSeconds - elapsed;
            if(rTotalSeconds > 3600){
                totalHours = Math.floor(rTotalSeconds / 3600);
                var rTotalHour = rTotalSeconds - (totalHours * 3600);
                if(rTotalHour >= 60){
                    totalMinutes =  Math.floor(rTotalHour / 60);
                    totalSeconds = rTotalHour - (totalMinutes * 60);
                }else{
                    totalMinutes = 0;
                    totalSeconds = rTotalHour;
                }
            }else{
                totalHours = 0;
                if(rTotalSeconds >= 60){
                    totalMinutes =  Math.floor(rTotalSeconds / 60);
                    totalSeconds = rTotalSeconds - (totalMinutes * 60);
                }else{
                    totalMinutes = 0;
                    totalSeconds = rTotalSeconds;
                }
            }
        }
        //====================================================
        
        for (i = 0; i < queues.length; i++) {
            var queue = queues[i].time;
            var queueSplit = queue.split(":");
            var _totalSeconds = parseInt(queueSplit[0]) * 60 * 60;
            _totalSeconds += parseInt(queueSplit[1]) * 60;
            _totalSeconds += parseInt(queueSplit[2]);
            if(elapsed >= _totalSeconds){
               elapsed = elapsed - _totalSeconds;
            }else{
                var rSeconds = _totalSeconds - elapsed;
                if(rSeconds >= 3600){
                    hours = Math.floor(rSeconds / 3600);
                    var rHour = rSeconds - (hours * 3600);
                    if(rHour >= 60){
                        minutes =  Math.floor(rHour / 60);
                        var rMinutes = rHour - (minutes * 60);
                        seconds = rMinutes;
                    }else{
                        minutes = 0;
                        seconds = rHour;
                    }
                }else{
                    hours = 0;
                    if(rSeconds >= 60){
                        minutes =  Math.floor(rSeconds / 60);
                        var rMinutes = rSeconds - (minutes * 60);
                        seconds = rMinutes;
                    }else{
                        minutes = 0;
                        seconds = rSeconds;
                    }
                }
                nextQueueIndex = i;
                setQueueColor();
                nextQueueIndex = nextQueueIndex + 1;
                if(ctimer.status === "RUNNING"){
                    runTimer();
                }
                
                if(ctimer.status === "PAUSE"){
                    displayLabels();
                    var btn = $(".pause-play");
                    btn.removeClass("btn-warning").addClass("btn-success");
                    $("i", btn).removeClass("fa-pause-circle").addClass("fa-play-circle");
                }
                break;
            }
        }
    }
};

var pause = function(){
    var elapsed = ctimer.time_now -  ctimer.date_started;
    if(ctimer.elapsed_time > 0){
        elapsed = ctimer.last_time_updated - ctimer.date_started;
    }
    continueTimer(elapsed);
};

var init = function(){
    var currentTimer = $("#currentTimer").val();
    var timerDetails = $("#timerDetails").val();
    if(timerDetails !== "" && currentTimer !== ""){
        ctimer = JSON.parse(currentTimer);
        queues = JSON.parse(timerDetails);
        openTimer();
        var elapsed = ctimer.time_now -  ctimer.date_started;
        if(ctimer.status === "RUNNING"){
            continueTimer(elapsed);
        }
        
        if(ctimer.status === "PAUSE"){
            if(ctimer.elapsed_time > 0){
                elapsed = ctimer.last_time_updated - ctimer.date_started;
            }
            continueTimer(elapsed);
        }
        
    }else{
        if (synth.speaking) {
            synth.cancel();
        }
        $("#modalItems").modal("show");
    }
};

$(window).resize(function(){
    updateItemHeight();
});


init();
updateItemHeight();
checkUpdate();

var bindRun = function(){
    $(".run").unbind("click").click(function () {
        var id = $(this).data("id");
        willCheckUpdate = false;
        $.get(real_url + "/task/details", {id:id}, function (result) {
            willCheckUpdate = true;
            queues = result;
            openTimer();
            setTimer(0, id, "OPEN");
        });
    });
};

$("document").ready(
    function () {
        $(".cancel-timer").click(function () {
            Swal.fire({
                title: "Are you sure you want to stop?",
                text: "This will stop the current timer event.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, stop it!",
                cancelButtonText: "No, continue!",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    setTimer(ctimer.id, ctimer.task_id, "DONE");
                    stopTimer();
                    $("#modalItems").modal("show");
                    $(".btnlist").show("fast");
                    $(".timer-control").hide("fast");
                }
            });
        });
        
        $(".pause-play").click(function () {
            var btn = $(this);
            if(btn.hasClass("btn-warning")){ //PAUSE
                btn.removeClass("btn-warning").addClass("btn-success");
                $("i", btn).removeClass("fa-pause-circle").addClass("fa-play-circle");
                clearInterval(timer);
                setTimer(ctimer.id, ctimer.task_id, "PAUSE");
            }else{ //PLAY
                btn.removeClass("btn-success").addClass("btn-warning");
                $("i", btn).removeClass("fa-play-circle").addClass("fa-pause-circle");
                setTimer(ctimer.id, ctimer.task_id, "RUNNING", function(){
                    runTimer();
                });
            }
        });
        
        $(".restart-timer").click(function () {
            stopTimer(true);
            setTimer(ctimer.id, ctimer.task_id, "RUNNING");
            setQueueItems();
            setQueueTimer();
            runTimer();
            computeTotalHours();
            bindTaskItem();
            
            //checkUpdate();
        });
        bindRun();
        $('[data-toggle="tooltip"]').tooltip();
        
        
//            var clientTimestamp = (new Date()).valueOf();
//            alert(real_url + '/synch-time?ct='+clientTimestamp);
//            $.getJSON(real_url + '/synch-time?ct='+clientTimestamp, function( data ) {
//                alert(data);
//                var nowTimeStamp = (new Date()).valueOf();
//                var serverClientRequestDiffTime = data.serverClientRequestDiffTime;
//                var serverTimestamp = data.serverTimestamp;
//                var serverClientResponseDiffTime = nowTimeStamp - serverTimestamp;
//                var responseTime = (serverClientRequestDiffTime - nowTimeStamp + clientTimestamp - serverClientResponseDiffTime )/2
//
//                var syncedServerTime = new Date((new Date()).valueOf() + (serverClientResponseDiffTime - responseTime));
//                alert(syncedServerTime);
//            });
    }
);

