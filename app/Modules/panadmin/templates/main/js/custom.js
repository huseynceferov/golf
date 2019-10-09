var Link = '';
$(document).on("click","[open-merchant-menu-modal]", function(){
    var merchantId = $(this).attr("merchant-id");
    $.ajax({
        type:'POST',
        url: Link+'/panadmin/Restaurant/showMenu',
        data: 'merchantId='+merchantId,
        success:function(data)
        {
            $("#modal_body").html(data);
        }
    });
});

$(document).on("click","[open-order-modal]", function(){
    var orderId = $(this).attr("order-id");
    $.ajax({
        type:'POST',
        url: Link+'/panadmin/Orders/showOrderItems',
        data: 'orderId='+orderId,
        success:function(data)
        {
            $("#modal_body").html(data);
        }
    });
});
$(document).on("click","[open-order-advanced]", function(){
    var orderId = $(this).attr("order-id");
    $.ajax({
        type:'POST',
        url:Link+'/panadmin/Orders/showAdvanced',
        data: 'orderId='+orderId,
        success:function(data)
        {
            $("#modal_body").html(data);
        }
    });
});
$(document).on("click",".btnBalance", function(e){
    e.preventDefault();
    var cardId = $(this).attr("data-id"),
        cardTitle = $(this).attr("data-m-title");
    $('#balanceModal #myModalLabel').html(cardTitle);
    $('#balanceModal .modal-body input[name=cardID]').val(cardId);
});
$(document).on("submit",".formBalance", function(e){
    e.preventDefault();
    var amount = $('.formBalance input[name=amount]').val();
    console.log(amount);
    if(amount<1){
        $(".errorResult").css({display: 'inline-block'}).html("<span>Məbləğ daxil edin</span>");
        setTimeout(function() {
            $(".errorResult").css({display: 'none'}).html('');
        }, 4000);
        return false;
    }
    $.ajax({
        type:'POST',
        url: Link+'/panadmin/Discount_cards/cardOperation',
        data: $(this).serializeArray(),
        success:function(data)
        {
            $("#balanceModal .modal-body").html(data);
            setTimeout(function() {
                window.location.href = "";
            }, 2000);
        },
        fail:function (data) {
            console.log(data);
        }
    });
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$('#submit1').click(function (e) {
    $('#submit1').slideUp();
    $("#land_zone").slideDown();
    e.preventDefault();
});

$(".getOptionsAlt").on("change", function(e) {
    // console.log(e);
    var contID = this.id;
    if(typeof e.added != 'undefined')
    {
        var islemID   = e.added.id;
        var islemText = e.added.text;

        $.post(Link+'/panadmin/Dishes/getOption',{class:"cuisine",func:"cuisineList",mainID:islemID}, function(data) {
            if(data.err==0)
            {
                $.each(data.data.data,function(i,k){
                    console.log(k.name_az);
                    //alert(k.name_az);
                    var strContent = $("#"+contID+"-content > div")[0].outerHTML;
                    strContent = strContent.replace("#deliveryName", k.name_az);
                    strContent = strContent.replace("display: none","");
                    strContent = strContent.replace(/#strc/g,k.id);
                    /*strContent = strContent.replace(/#st1/g,k.id);*/
                    strContent = strContent.replace(/#contID/g,islemID);
                    strContent = strContent.replace(/#isinsertOptnsV/g,k.isinsertOptns);
                    $("#"+contID+"-content").append(strContent);
                });
            }
            else
            {
                alert(data.msg);
            }
        }, 'json');


    }
    if(typeof e.removed != 'undefined')
    {
        var removID = e.removed.id;
        $(".remove-"+removID).remove();
        console.log("sildi31231231");
    }
});

/*$('.formSubmit').on('submit',function (e) {
    e.preventDefault();
    console.log($(this).serializeArray());
    $.ajax({
        type:'POST',
        url:'/admin/Dishes/create',
        data: $(this).serializeArray(),
        dataType: 'json',
        encode: true
    })
        .done(function(data) {
            if ( ! data.success) {
                console.log(data);
            }else{
                console.log(data);
                alert(1);
            }
        }).fail(function (data) {
        console.log(data);
    })
});*/

function multiSelec2()
{
    $(".multiSelect2").on("change", function(e) {
        //console.log(e);
        /*console.log("change " + JSON.stringify({
                val: e.val,
                added: e.added,
                removed: e.removed
            }));

        if (e.added) {
            alert('added: ' + e.added.text + ' id ' + e.added.id)
        } else if (e.removed) {
            alert('removed: ' + e.removed.text + ' id ' + e.removed.id)

        }*/
        if(typeof e.added != 'undefined')
        {
            var islemID   = e.added.id;
            var islemText = e.added.text;
            //alert("asdas"+islemID);
            if(typeof e.added.element[0] != 'undefined')
            {
                var price     = e.added.element[0];
            }
            //console.log("#"+this.id+"-content > div");

            var strContent = $("#"+this.id+"-content > div")[0].outerHTML;
            strContent = strContent.replace("#deliveryName",islemText);
            if(typeof price.attributes['valprice'] != 'undefined')
            {
                strContent = strContent.replace("#prc",price.attributes['valprice'].nodeValue);
            }
            strContent = strContent.replace("display: none","");
            strContent = strContent.replace(/#strc/g,islemID);
            //alert();
            $("#"+this.id+"-content").append(strContent);

        }
        if(typeof e.removed != 'undefined')
        {
            var removID = e.removed.id;
            var removText = e.removed.text;
            $felan = $(this).attr("data-id");
            //alert("#"+$felan+"-"+removID);
            $("#"+$felan+"-"+removID).remove();


        }


    });
}

multiSelec2();
