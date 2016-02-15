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
  
  /* hotels toggle */
  $('.hotel').addClass('js');
  $('.hotel header a').attr('href','javascript:;');
  
  
  $('.home .alt-navbar').css('height',$(window).height());
  
  $('.hotel-alt').addClass('js');
  
  if($(window).width()>976){
    $h_hotel = 13 * $(window).width()/4/25;
    $w_hotel = $(window).width()/4;
  }else if($(window).width()>752){
    $h_hotel = 225;
    $w_hotel = $(window).width()/2;
  }else{
    $h_hotel = 13 * $(window).width()/25;
    $w_hotel = $(window).width();
  }
  
  if($(window).height()/2-81 > 215){
      $p_logo = $(window).height()/2-81;
    }else{
      $p_logo = 215;
    }
  
  $('.hotel,.hotel header a,.hotel-img,.hotel header a div').css('height',$h_hotel+'px');
  $('.hotel header a div').css('width',$w_hotel+'px');
  $('.hotel-img').css('margin-bottom','-'+$h_hotel+'px');

  if($(window).width()>1084){
    $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-181+'px');
  }else if($(window).width()>752){
    $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-140+'px');
  }else{
    $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-70+'px');
  }

  $('.alt-navbar h2').css('padding-top',$p_logo+'px');
  
  if($(window).height()<980){
    if($(window).width()>752){
      $('.hotels').css('position','absolute');
    }
    $top = $(window).height()-$h_hotel;
    if($(window).width()>752){
      $('.hotel,.hotel header a,.hotel-img').css('top',$top+'px');
    }
  }else{
    $('.hotels').css('position','relative');
    if($(window).width()>752){
      $('.hotel,.hotel header a,.hotel-img').css('top','-'+$h_hotel+'px');
    }
  }
 
  $(window).resize(function(){
    $('.home .alt-navbar').css('height',$(window).height());
    

    if($(window).width()>976){
      $h_hotel = 13 * $(window).width()/4/25;
      $w_hotel = $(window).width()/4;
    }else if($(window).width()>752){
      $h_hotel = 225;
      $w_hotel = $(window).width()/2;
    }else{
      $h_hotel = 13 * $(window).width()/25;
      $w_hotel = $(window).width();
    }
    
    if($(window).height()/2-81 > 215){
      $p_logo = $(window).height()/2-81;
    }else{
      $p_logo = 215;
    }

    $('.hotel,.hotel header a,.hotel-img,.hotel header a div').css('height',$h_hotel+'px');
    $('.hotel header a div').css('width',$w_hotel+'px');
    $('.hotel-img').css('margin-bottom','-'+$h_hotel+'px');
    if($(window).width()>1084){
      $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-181+'px');
    }else if($(window).width()>752){
      $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-140+'px');
    }else{
      $('.fpip-container,.fpip-content').css('height',$(window).height()-$('.hotel-img').height()-70+'px');
    }
    $('.alt-navbar h2').css('padding-top',$p_logo+'px');

    if($(window).height()<980){
      $top = $(window).height()-$h_hotel;
      if($(window).width()>752){
        $('.hotels').css('position','absolute');
        $('.hotel,.hotel header a,.hotel-img').css('top',$top+'px');
      }else{
        $('.hotels').css('position','relative');
        $('.hotel,.hotel header a,.hotel-img').css('top','auto');
      }
      $('.hotel').removeClass('open');
      $('.hotel header a').css('height',$h_hotel+'px');
      $('.hotel header a').css('padding-top',0);
      $('.hotel header a div').css('height',$h_hotel+'px');
    }else{
      $('.hotels').css('position','relative');
      if($(window).width()>752){
        $('.hotel,.hotel header a,.hotel-img').css('top','-'+$h_hotel+'px');
      }
      $('.hotel').removeClass('open');
      $('.hotel header a').css('height',$h_hotel+'px');
      $('.hotel header a').css('padding-top',0);
      $('.hotel header a div').css('height',$h_hotel+'px');
    }

  });
  
  $('.hotel').click(function(){
    if($(window).height()<980){
      $('.hotel').removeClass('open');
      if($(window).width()>752){
        $('.hotel').css('top',$top+'px');
      }
      $('.hotel header a').css('height',$h_hotel+'px');
      $('.hotel header a').css('padding-top',0);
      $('.hotel header a div').css('height',$h_hotel+'px');
      $(this).addClass('open');
      if($(window).width()>752){
        $(this).css('top','206px');
      }
      $('.hotel.open header a').css('height',$h_hotel+90+'px');
      $('.hotel.open header a').css('padding-top',$h_hotel+'px');
      $('.hotel.open header a div').css('height','90px');
    }else{
      $('.hotel').removeClass('open');
      if($(window).width()>752){
        $('.hotel').css('top','-'+$h_hotel+'px');
      }
      $('.hotel header a').css('height',$h_hotel+'px');
      $('.hotel header a').css('padding-top',0);
      $('.hotel header a div').css('height',$h_hotel+'px');
      $(this).addClass('open');
      if($(window).width()>752){
        $(this).css('top','-780px');
      }
      $('.hotel.open header a').css('height',$h_hotel+90+'px');
      $('.hotel.open header a').css('padding-top',$h_hotel+'px');
      $('.hotel.open header a div').css('height','90px');
    }
  });
  $('.hotel .to-close').click(function(){
    if($(window).height()<980){
      setTimeout(function(){
        $('.hotel').removeClass('open');
        if($(window).width()>752){
          $('.hotel').css('top',$top+'px');
        }
        $('.hotel header a').css('height',$h_hotel+'px');
        $('.hotel header a').css('padding-top',0);
        $('.hotel header a div').css('height',$h_hotel+'px');
      },1);
    }else{
      setTimeout(function(){
        $('.hotel').removeClass('open');
        if($(window).width()>752){
          $('.hotel').css('top','-'+$h_hotel+'px');
        }
        $('.hotel header a').css('height',$h_hotel+'px');
        $('.hotel header a').css('padding-top',0);
        $('.hotel header a div').css('height',$h_hotel+'px');
      },1);
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
