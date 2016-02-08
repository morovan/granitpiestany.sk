$(function(){
  
  $('.submit').attr('type','button');
  $('.booking-hotel').addClass('disabled');
  
  
  $('#booking').change(function(){
    if($('#booking').is(':checked')){
      if($(window).width()>767){
        if($(window).height()<620){
          $('.booking').css('height',$(window).height()+'px');
        }else{
          $('.booking').css('height','530px');
        }
      }else{
        $('.booking').css('height','auto');
      }
      $('.header-booking-btn').addClass('js');
    }else{
      $('.booking').css('height',0);
      $('.header-booking-btn').removeClass('js');
    }
  });
  $('.booking-close').click(function(){
    $('.booking').css('height',0);
    $('#booking').prop('checked',false);
    $('.header-booking-btn').removeClass('js');
  });
  $('.booking-btn').click(function(){
    if($(window).width()>767){
      if($(window).height()<620){
        $('.booking').css('height',$(window).height()+'px');
      }else{
          $('.booking').css('height','530px');
        }
      }else{
        $('.booking').css('height','auto');
      }
    $('#booking').prop('checked',true);
    $('.header-booking-btn').addClass('js');
  });
  
  
  $(window).resize(function(){
    if($('#booking').is(':checked')){
      if($(window).width()>767){
        if($(window).height()<620){
          $('.booking').css('height',$(window).height()+'px');
        }else{
          $('.booking').css('height','530px');
        }
      }else{
        $('.booking').css('height','auto');
      }
    }
  });
  
  
 
  
  
  
  $('.booking-form').each(function(){
    $id = '#'+$(this).attr('id')+' ';
    $idw = '#picker-wrap_'+$(this).attr('id')+' ';
    
    $('#loader').before('<div id="picker-wrap_'+$(this).attr('id')+'"><div class="pickdate1 pickdatewrap"></div><div class="pickdate2 pickdatewrap"></div></div>');
  
    $($id+'.booking-room-min-2,'+$id+'.booking-room-min-3,'+$id+'.booking-room-min-4,'+$id+'.booking-room-min-5').hide();
    $($id+'.booking-summary-dynamic').show();

    $($id+'.booking-summary-hotel').html($($id+'.valid').val());

    $($id+'.check-in').change(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';
      $($id+'.booking-summary-check-in').html($(this).val());
    });
    $($id+'.check-out').change(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';
      $($id+'.booking-summary-check-out').html($(this).val());
    });
    $($id+'.booking-room').change(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';
      $($id+'.booking-summary-room').html($(this).val());
      if($($id+'.booking-room').val()==2){
        $($id+'.booking-summary-room-text-2').show();
        $($id+'.booking-summary-room-text-1,'+$id+'.booking-summary-room-text-5').hide();
        $($id+'.booking-room-min-2').show();
        $($id+'.booking-room-min-3,'+$id+'.booking-room-min-4,'+$id+'.booking-room-min-5').hide();
      }else if($($id+'.booking-room').val()==3){
        $($id+'.booking-summary-room-text-2').show();
        $($id+'.booking-summary-room-text-1,'+$id+'.booking-summary-room-text-5').hide();
        $($id+'.booking-room-min-2,'+$id+'.booking-room-min-3').show();
        $($id+'.booking-room-min-4,'+$id+'.booking-room-min-5').hide();
      }else if($($id+'.booking-room').val()==4){
        $($id+'.booking-summary-room-text-2').show();
        $($id+'.booking-summary-room-text-1,'+$id+'.booking-summary-room-text-5').hide();
        $($id+'.booking-room-min-2,'+$id+'.booking-room-min-3,'+$id+'.booking-room-min-4').show();
        $($id+'.booking-room-min-5').hide();
      }else if($($id+'.booking-room').val()>=5 || $($id+'.booking-room').val()=='9+'){
        $($id+'.booking-summary-room-text-5').show();
        $($id+'.booking-summary-room-text-1,'+$id+'.booking-summary-room-text-2').hide();
        $($id+'.booking-room-min-2,'+$id+'.booking-room-min-3,'+$id+'.booking-room-min-4,'+$id+'.booking-room-min-5').show();
      }else{
        $($id+'.booking-summary-room-text-1').show();
        $($id+'.booking-summary-room-text-2,'+$id+'.booking-summary-room-text-5').hide();
        $($id+'.booking-room-min-2,'+$id+'.booking-room-min-3,'+$id+'.booking-room-min-4,'+$id+'.booking-room-min-5').hide();
      }
    });
    $($id+'.booking-person').change(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';
      $($id+'.booking-summary-person').html($(this).val());
      if($($id+'.booking-person').val()==1){
        $($id+'.booking-summary-person-text-1').show();
        $($id+'.booking-summary-person-text-2,'+$id+'.booking-summary-person-text-5').hide();
      }else if($($id+'.booking-person').val()>=2 && $($id+'.booking-person').val()<5){
        $($id+'.booking-summary-person-text-2').show();
        $($id+'.booking-summary-person-text-1,'+$id+'.booking-summary-person-text-5').hide();
      }else{
        $($id+'.booking-summary-person-text-5').show();
        $($id+'.booking-summary-person-text-1,'+$id+'.booking-summary-person-text-2').hide();
      }
    });

    /* datepicker */
    $today = new Date();
    $dd = $today.getDate();
    $mm = $today.getMonth();
    $yyyy = $today.getFullYear();

    $($id+'.datepicker').attr('type','text');
    $($id+'.check-in').pickadate({
      container:$idw+'.pickdate1',
      closeOnSelect:true,
      closeOnClear:true,
      min:new Date($yyyy,$mm,$dd)
    });
    $($idw+'.pickdate1 .picker__wrap').before('<div class="picker-title">'+$($id+'.check-in').attr('placeholder')+'</div>');

    $($id+'.check-out').pickadate({
      container:$idw+'.pickdate2',
      closeOnSelect:true,
      closeOnClear:true,
      min:new Date($yyyy,$mm,$dd)
    });

    $input = $($id+'.check-out').pickadate();
    $picker = $input.pickadate('picker');

    $($id+'.check-out').addClass('js');
    $($id+'.check-out').attr('disabled','disabled');

    $picker.stop();

    $cot=false;

    $($id+'.check-in').change(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';

      $idw = '#picker-wrap_'+$(this).closest('.booking-form').attr('id')+' ';

      $($id+'.check-out').pickadate({
        container:$idw+'.pickdate2',
        closeOnSelect:true,
        closeOnClear:true,
        min:new Date($yyyy,$mm,$dd)
      });
      
      if($($idw+'.pickdate2 .picker-title').length){
      }else{
        $($idw+'.pickdate2 .picker__wrap').before('<div class="picker-title">'+$($id+'.check-out').attr('placeholder')+'</div>');
      }

      $input = $($id+'.check-out').pickadate();
      $picker = $input.pickadate('picker');
      if($($id+'input[name=check_in_submit]').val()==''){
        $($id+'.check-out').addClass('js');
        $($id+'.check-out').attr('disabled','disabled');
        $picker.stop();
      }else{
        $($id+'.check-out').removeClass('js');
        $($id+'.check-out').removeAttr('disabled');
        $picker.start().clear().open();
        $picker.set('enable', true);
        $picker.set('min', new Date($($id+'input[name=check_in_submit]').val()));
        $picker.set('disable', [new Date($($id+'input[name=check_in_submit]').val())]);
      }
    });
    
    $($id+'.submit').click(function(){
      $id = '#'+$(this).closest('.booking-form').attr('id')+' ';
      if($($id+'input[name=check_in_submit]').val()==''){
        $($id+'.check-in').addClass('has-error');
        $($id+'input[name=check_in_submit]+span').html($('.error-text').html());
      }else{
        $($id+'.check-in').removeClass('has-error');
        $($id+'input[name=check_in_submit]+span').html('');
      }
      if($($id+'input[name=check_out_submit]').val()==''){
        $($id+'.check-out').addClass('has-error');
        $($id+'input[name=check_out_submit]+span').html($('.error-text').html());
      }else{
        $($id+'.check-out').removeClass('has-error');
        $($id+'input[name=check_out_submit]+span').html('');
      }
      if($($id+'.booking-name').val()==''){
        $($id+'.booking-name').addClass('has-error');
        $($id+'.booking-name+span').html($('.error-text').html());
      }else{
        $($id+'.booking-name').removeClass('has-error');
        $($id+'.booking-name+span').html('');
      }
      if($($id+'.booking-surname').val()==''){
        $($id+'.booking-surname').addClass('has-error');
        $($id+'.booking-surname+span').html($('.error-text').html());
      }else{
        $($id+'.booking-surname').removeClass('has-error');
        $($id+'.booking-surname+span').html('');
      }
      if($($id+'.booking-phone').val()=='' && $($id+'.booking-email').val()==''){
        $($id+'.booking-phone').addClass('has-error');
        $($id+'.booking-email').addClass('has-error');
        $($id+'.booking-phone+span').html($('.error-text-2').html());
      }else{
        $($id+'.booking-phone').removeClass('has-error');
        $($id+'.booking-email').removeClass('has-error');
        $($id+'.booking-phone+span').html('');
      }
      if($($id+'.valid').length>0){
      }else{
        $($id+'.booking-hotel').addClass('has-error');
        $($id+'.booking-hotel+span').html($('.error-text').html());
      }
      if($($id+'input[name=check_in_submit]').val()!='' && $($id+'input[name=check_out_submit]').val()!='' && $($id+'.booking-name').val()!='' && $($id+'.booking-surname').val()!='' && $($id+'.valid').length>0){
          if($($id + '.booking-phone').val() == '' && $($id + '.booking-email').val() == ''){
            $($id + '.has-error').focus();
          }else{
            $($id + 'form').submit();
          }
      }else{
        $($id+'.has-error').focus();
      }
    });
    $($id+'.booking-name').change(function(){
      if($($id+'.booking-name').val()==''){
        $($id+'.booking-name').addClass('has-error');
        $($id+'.booking-name+span').html($('.error-text').html());
      }else{
        $($id+'.booking-name').removeClass('has-error');
        $($id+'.booking-name+span').html('');
      }
    });
    $($id+'.booking-surname').change(function(){
      if($($id+'.booking-surname').val()==''){
        $($id+'.booking-surname').addClass('has-error');
        $($id+'.booking-surname+span').html($('.error-text').html());
      }else{
        $($id+'.booking-surname').removeClass('has-error');
        $($id+'.booking-surname+span').html('');
      }
    });
    $($id+'.booking-phone').change(function(){
      if($($id+'.booking-phone').val()==''){
        $($id+'.booking-phone').addClass('has-error');
        $($id+'.booking-phone+span').html($('.error-text').html());
      }else{
        $($id+'.booking-phone').removeClass('has-error');
        $($id+'.booking-phone+span').html('');
      }
    });
  
  });
  
  

});