$(document).ready(function(){



  $('#toggleMenu').click(function() {

    $(this).toggleClass('active');
    $(this).closest('.toggle-wrap').toggleClass('active');

    $('.header_menu').toggleClass('show-menu')

  });

  


});