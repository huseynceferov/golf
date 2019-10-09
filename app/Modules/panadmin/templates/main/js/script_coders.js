$(document).ready(function(){

    //search box visibility
    $(".search-box-link").click(function(){
        $(".search-box").slideToggle();
    });

    //switch checkbox initial
    $(".switch_checkbox").bootstrapSwitch();

    //confirm initial
    $(".delete_confirm").confirmation({
            'title':'Əminsinizmi?',
            'btnOkLabel':'Bəli',
            'btnCancelLabel':'Xeyr'
        }
    );


    //all-check
    $(".all-check").click(function(){
        if($(this).prop("checked")){
            $('td input:checkbox').each(function() {
                $(this).attr("checked", "checked");
                $(this).prop("checked", true);
                id=$(this).data("id");

            });
        }
        else{
            $('td input:checkbox').each(function() {
                $(this).removeAttr("checked", "checked");
                $(this).prop("checked", false);
            });
        }
    });

    //datetimepicker
    $('.datetimepicker').datetimepicker({
        inline: false,
        sideBySide: false,
        format: 'DD.MM.YYYY HH:mm',
    });

    //datetimepicker
    $('.datepicker').datetimepicker({
        format: 'DD.MM.YYYY',
    });

    $('.timepicker').datetimepicker({
        format: 'HH:mm',
    });

});

function statusChange(id){
     var baseUrl = $("#baseUrl").val();
     $.post(baseUrl+"/status/"+id,{},function(data){

    });
 }

function show_flag(value)
{
    $("#flag_image").attr("src",value);
}


/***** File upload **/

var $team_tr = $('.team_tr');
var $team_modal = $('#teamModal');
var $team_form = $('.team_form');

$('.team_form input[type=file]').on('change', function(e) {

    // $("input#on_select").trigger("keypress") // you can trigger keypress like this if you need to..
    //         .val(function(i,val){return val + 'a';});

    $("input#on_select").trigger("keyup"); // you can trigger keypress like this if you need to..

});
// change team info
$team_form.on('keyup', function(){

    data = new FormData($(this)[0]);
    data.append('file', $('#tm_photo')[0].files[0]);
    console.log(data);
    $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data: data,
            dataType: 'json',
            processData: false,
            cache : false,
            contentType: false,
            beforeSend: function () {
                $team_form.find('.loader').show();
            }
        })
        // using the done promise callback
        .done(function(data) {

            console.log(data);

            if ( ! data.success) {
                //alert(data.errors.length);
                for (var key in data.errors){
                    var value = data.errors[key];
                    var errors = "- " + value + ". ";

                }
                alert(errors);

            } else {

                var tm_tr_id = $team_form.find('#tm_id').val();

                var img_time = Math.floor(Date.now() / 1000);
                $team_form.find('#tm_photo').val('');
                $('#team-'+ tm_tr_id).find('.show_name').text($team_form.find('#tm_name').val());
                $('#team-'+ tm_tr_id).find('.show_power').text($team_form.find('#tm_power').val());
                $('#tr-'+ tm_tr_id).find('.show_founded span').text($team_form.find('#tm_founded').val());
                $('#tr-'+ tm_tr_id).find('.show_city span').text($team_form.find('input#tm_city').val());
                $('#tr-'+ tm_tr_id).find('.show_stadium span').text($team_form.find('input#tm_stadium').val());
                $('#tr-'+ tm_tr_id).find('.show_capacity span').text($team_form.find('input#tm_capacity').val());
                $('#tr-'+ tm_tr_id).find('.show_url a').text($team_form.find('input#tm_url').val());
                $('#tr-'+ tm_tr_id).find('.show_url a').attr('href', $team_form.find('input#tm_url').val());
                $('#tr-'+ tm_tr_id).find('.show_logo').attr('src', '/images/teams/100/' + data.message.image + '?'+ img_time);
                $team_form.find('.tm_thumb').attr('src', '/images/teams/100/' + data.message.image + '?'+ img_time);
                $('#tr-'+ tm_tr_id).find('.show_coach span').text($team_form.find('input#tm_coach').val());

                $team_form.find('.loader').hide();
                // ALL GOOD! just show the success message!
                //alert(data.message.image_url);
                // setTimeout(function() {
                //     location.reload();
                // }, 2000);
            }
        })

        // using the fail promise callback
        .fail(function(data) {
            //console.log(data);
        });

    //return false;
});
