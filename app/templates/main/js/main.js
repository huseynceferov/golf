$(window).scroll(function(){
    $('#main-page-nav').toggleClass('bg-white navbar-light ', $(this).scrollTop() > 1);
    $('#main-page-nav').toggleClass('bg-transparent navbar-dark pt-5', $(this).scrollTop() < 1); 
    $('.search-button').toggleClass('search-button-black', $(this).scrollTop() > 1)
});