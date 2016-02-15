$(function(){
  /* introduction */
  $('.social.print').css('display','block');
  $('.navbar-fixed-top').addClass('js');
  $('.booking-close').addClass('js');
  $('.our-hotel-img-sidebar').addClass('js');
  $('.hp-video').addClass('js');
  
  /* scroll to top */
  $(window).scroll(function(){
    if($(this).scrollTop() > 200){
      $('#totop').fadeIn();	
    }else{
      $('#totop').fadeOut();
    }
  });
  $('#totop').click(function(){
    $('body,html').animate({scrollTop:0},800);
  });
  
  /* search */
  $('#fullsearch').css('display','block');
  $('.nav>li.search-menu').css('display','block');
  $('#fullsearch').hide();
  $('#fullsearch .searchform').css('margin-top',$(window).height()/2-30);
  $(window).resize(function(){
    $('#fullsearch .searchform').css('margin-top',$(window).height()/2-30);
  });
  $('#fullsearch input').focus(function(){
    $('#fullsearch .searchform').addClass('focus');
  });
  $('#fullsearch input').focusout(function(){
    $('#fullsearch .searchform').removeClass('focus');
  });
  $('.search-menu').click(function(){
    $('#fullsearch').fadeIn('quick');
    $('#fullsearch input[type=text]').focus();
  });
  $('.searchform-close').click(function(){
    $('#fullsearch').fadeOut('quick');
  });

  // height fix
  $('.height-fix-to').height($('.height-fix-from').height());
  $(window).resize(function(){
    $('.height-fix-to').height($('.height-fix-from').height());
  });
  
  /* menu */
  if($(window).width() > 752){
    if($(window).scrollTop() > 105){
      $('.navbar-fixed-top').addClass('scroll');
    }
  }
  $(window).scroll(function(){
    if($(window).width() > 752){
      if($(this).scrollTop() > 105){
        $('.navbar-fixed-top').addClass('scroll');	
      }else{
        $('.navbar-fixed-top').removeClass('scroll');
      }
    }
  });
  $lango=false;
  $('.navbar-nav.lang>li>a').click(function(){
    if($lango==false){
      $('.lang .sub-menu').addClass('click');
      $lango=true;
    }else{
      $('.lang .sub-menu').removeClass('click');
      $lango=false;
    }
  });

  
  
  if($(window).width()>1084){
    $('.fpip-container,.fpip-content').css('height',$(window).height()-441+'px');
  }else if($(window).width()>752){
    $('.fpip-container,.fpip-content').css('height',$(window).height()-402+'px');
  }else{
    $('.fpip-container,.fpip-content').css('height','auto');
  }
  $(window).resize(function(){
    if($(window).width()>1084){
      $('.fpip-container,.fpip-content').css('height',$(window).height()-441+'px');
    }else if($(window).width()>752){
      $('.fpip-container,.fpip-content').css('height',$(window).height()-402+'px');
    }else{
      $('.fpip-container,.fpip-content').css('height','auto');
    }
  });

  /* video modal */
  if($(window).height()<630) {
    $('.c-video').height($(window).height() - 140 + 'px');
  }else{
    $('.c-video').height('490px');
  }
  $(window).resize(function(){
    if($(window).height()<630) {
      $('.c-video').height($(window).height() - 140 + 'px');
    }else{
      $('.c-video').height('490px');
    }
  });
  
  
  
  
});

/* share */
function nwindow() {
  var nwindow = window.open("", "ppw", 'width=650, height=300, top=85, left=100, toolbar=0, location=0, scrollbars=1, resizable=1');
  nwindow.focus();
}
