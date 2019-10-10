$(window).scroll(function(){
    $('#main-page-nav').toggleClass('bg-white navbar-light ', $(this).scrollTop() > 1);
    $('#main-page-nav').toggleClass('bg-transparent navbar-dark pt-5', $(this).scrollTop() < 1); 
    $('.search-button').toggleClass('search-button-black', $(this).scrollTop() > 1)
});

$('#form_subscribe').submit(function(event) {
    $.ajax({
        type: 'POST',
        url: 'request/subscriber',
        data:  $(this).serializeArray(),
        dataType: 'json',
        encode: true
    }).done(function(data) {
        if(data.success){
            $('#form_subscribe input[name=subscriber]').value();
            toastr.success(data.message);
        }else{
            toastr.error(data.message);
        }
    });
    event.preventDefault();
});
