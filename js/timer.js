var curobj = null;
var newHtml;
var curid;
$(function(){
    $('.timerdetails').on('click',null,function(){
        curid = $(this).attr('tid');
        var timerid = 't' + curid;
        $(this).toggleClass('timerdetailsopen');
        if ($('.details[tid="'+curid+'"]').html() == ""){
            $.ajax({
                url: 'ajax/timerdetails.php?tid=' + curid,
                context:document.body
            }).done(function(data){
                $('.details[tid="'+curid+'"]').html(data);
            });
            
        } else {
            $('.details[tid="'+curid+'"]').html('');
        }
    });

    $('.deltimer').on('click',null,function(){
        var go = confirm("Ben je zeker dat je deze Werktimer wilt verwijderen?");
        if (go){
            var timerid = 't' + $(this).attr('tid');
            $.ajax({
                url:'ajax/delTimer.php?tid='+ $(this).attr('tid'),
                context: document.body
            })
            .done(function(data){
                if (data == 'ok'){
                    $('#'+timerid).remove();
                }
            });
        }
    });

    $('.timeraction').on('click',null,function(){
        curid = $(this).attr('tid');
        var timerid = 't' + curid;
        curobj = $(this);
        var action = $(this).html();
        if (action == 'Start'){
            newHtml = 'Stop';
            var url = 'ajax/startTimer.php?tid='+ curid;
        } else {
            newHtml = 'Start';
            var url = 'ajax/stopTimer.php?tid='+ curid;
        }
        $.ajax({
            url:url,
            context: document.body
        })
        .done(function(data){
            if (data == 'ok'){
                curobj.html(newHtml)
                    .toggleClass('stoptimer')
                    .toggleClass('starttimer');
                if (newHtml == 'Start'){
                    $.ajax({
                        url: 'ajax/getTotalTime.php?tid=' + curid,
                        context:document.body
                    })
                    .done(function(data){
                        $('.totaltime[tid="'+curid+'"]').html(data);
                    })

                }
            }
        });
    });
});
