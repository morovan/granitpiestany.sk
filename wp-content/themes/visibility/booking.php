<form method="POST" action="<?php echo get_template_directory_uri(); ?>/upload.php">
<div class="error-text sr-only"><?php echo trans('fill_required_field_lang', 'Fill required field'); ?></div>
<div class="error-text-2 sr-only"><?php echo trans('fill_one_required_field_lang', 'Fill in one of these fields'); ?></div>
<img src="<?php echo get_template_directory_uri(); ?>/images/date-hover.png" alt="" class="sr-only"><img src="<?php echo get_template_directory_uri(); ?>/images/select-hover.png" alt="" class="sr-only">
<input type="text" name="first_name" class="sr-only">
<input type="hidden" name="lang" value="<?php echo substr(get_locale(),0,-3); ?>">
<input type="hidden" name="url" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
<div class="row">
  <div class="col-sm-6 col-md-3">
    Hotel GRANIT
    <strong class="selected-hotel">Piešťany</strong>
    <input type="hidden" name="hotel" value="Piešťany" class="valid">
  </div>
  <div class="col-sm-6 col-md-3">
    <label>
      <?php echo trans('check_in_lang', 'Check-in'); ?>
      <input type="date" name="check_in" class="form-control datepicker check-in" placeholder="<?php echo trans('check_in_lang', 'Check-in'); ?>"><span></span>
    </label>
  </div>
  <div class="col-sm-6 col-md-3">
    <label>
      <?php echo trans('check_out_lang', 'Check-out');  ?>
      <input type="date" name="check_out" class="form-control datepicker check-out" placeholder="<?php echo trans('check_out_lang', 'Check-out'); ?>"><span></span>
    </label>
  </div>
  <div class="col-sm-6 col-md-3">
    <div class="row">
      <div class="col-xs-6">
        <label>
          <?php echo trans('number_of_rooms_lang', 'Number of rooms'); ?>
          <select name="room" class="form-control booking-room">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>9+</option>
          </select>
        </label>
      </div>
      <div class="col-xs-6">
        <label>
          <?php echo trans('number_of_people_lang', 'Number of persons'); ?>
          <select name="person" class="form-control booking-person">
            <option>1</option>
            <option selected>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option class="booking-room-min-2">9</option>
            <option class="booking-room-min-2">10</option>
            <option class="booking-room-min-2">11</option>
            <option class="booking-room-min-2">12</option>
            <option class="booking-room-min-2">13</option>
            <option class="booking-room-min-2">14</option>
            <option class="booking-room-min-2">15</option>
            <option class="booking-room-min-2">16</option>
            <option class="booking-room-min-3">17</option>
            <option class="booking-room-min-3">18</option>
            <option class="booking-room-min-3">19</option>
            <option class="booking-room-min-3">20</option>
            <option class="booking-room-min-3">21</option>
            <option class="booking-room-min-3">22</option>
            <option class="booking-room-min-3">23</option>
            <option class="booking-room-min-3">24</option>
            <option class="booking-room-min-4">25</option>
            <option class="booking-room-min-4">26</option>
            <option class="booking-room-min-4">27</option>
            <option class="booking-room-min-4">28</option>
            <option class="booking-room-min-4">29</option>
            <option class="booking-room-min-4">30</option>
            <option class="booking-room-min-4">31</option>
            <option class="booking-room-min-4">32</option>
            <option class="booking-room-min-5">33</option>
            <option class="booking-room-min-5">34</option>
            <option class="booking-room-min-5">35</option>
            <option class="booking-room-min-5">36</option>
            <option class="booking-room-min-5">37</option>
            <option class="booking-room-min-5">38</option>
            <option class="booking-room-min-5">39</option>
            <option class="booking-room-min-5">39+</option>
          </select>
        </label>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-3">
    <?php echo trans('your_name_lang', 'Your name');?>
    <input type="text" name="name" class="form-control booking-name" placeholder="<?php echo trans('your_name_lang', 'Your name'); ?>"><span></span>
  </div>
  <div class="col-sm-6 col-md-3">
    <?php echo trans('surname_lang', 'Surname'); ?>
    <input type="text" name="surname" class="form-control booking-surname" placeholder="<?php echo trans('surname_lang', 'Surname'); ?>"><span></span>
  </div>
  <div class="col-md-6 col-sm-12">
    <?php echo trans('contact_data_lang', 'Phone/E-mail - Enter at least one contact data'); ?>
    <div class="row">
      <div class="col-sm-6">
        <input type="text" name="phone" class="form-control booking-phone" placeholder="<?php echo trans('phone_lang', 'Phone'); ?>"><span></span>
      </div>
      <div class="col-sm-6">
        <input type="text" name="email" class="form-control booking-email" placeholder="<?php echo trans('mail_lang', 'E-mail'); ?>">
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <?php echo trans('special_requirements_comment_optional_lang', 'Special requirements comment (optional)'); ?>
    <textarea name="message" class="form-control" placeholder="<?php echo trans('message_lang', 'Message'); ?>"></textarea>
  </div>
  <div class="col-sm-2 col-md-3 booking-summary">
    <span class="ion-ios-arrow-thin-right ion"></span>
    <div class="booking-summary-dynamic">
      <div class="booking-summary-hotel">&nbsp;</div>
      <div><span class="booking-summary-check-in"></span> - <span class="booking-summary-check-out"></span></div>
      <div><span class="booking-summary-room">1</span> <span class="booking-summary-room-text-1"><?php echo trans('1_room_lang', 'room'); ?></span><span class="booking-summary-room-text-2"><?php echo trans('2_rooms_lang', 'rooms') ?></span><span class="booking-summary-room-text-5"><?php echo trans('5_rooms_lang', 'rooms')?></span></div>
      <div><span class="booking-summary-person">2</span> <span class="booking-summary-person-text-1"><?php  echo trans('1_person_lang', 'person');?></span><span class="booking-summary-person-text-2"><?php echo trans('2_persons_lang', 'persons'); ?></span><span class="booking-summary-person-text-5"><?php echo trans('5_persons_lang','persons'); ?></span></div>
    </div>
  </div>
  <div class="col-sm-4 col-md-3">
    <input type="submit" class="form-control submit" value="<?php echo trans('book_lang', 'Book now'); ?>">
    <div class="booking-contact-email-phone">
      alebo nás kontaktujte na:
      <div>
        <span itemprop="email"><a href="mailto:recepcia.pn@granithotels.sk" class="bcea"><span class="ion-ios-email-outline ion"></span><span class="bce">recepcia.pn@granithotels.sk</span></span></a>
      </div>
      <div>
        <span itemprop="telephone"><a href="tel:+421337983111" class="bcpa"><span class="ion-ios-telephone-outline ion"></span><span class="bcp">+421 (0) 33 7983 111</span></span></a>
      </div>
    </div>
  </div>
</div>
</form>