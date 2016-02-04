<?php
header('Content-type: text/html; charset=utf-8');
$servername = "localhost";
$dbname   = "granit";
$username = "granit";
$password = "visi0579";

$hotel = $_POST['hotel'];
if($hotel=='Hotel Granit Smrekovica'){
  $tomail = 'recepcia.sm@granithotels.sk';
}else if($hotel=='Hotel Granit Zemplínska šírava'){
  $tomail = 'recepcia.zs@granithotels.sk';
}else if($hotel=='Hotel Granit Tatranské Zruby'){
  $tomail = 'recepcia.tz@granithotels.sk';
}else if($hotel=='Hotel Granit Piešťany'){
  $tomail = 'recepcia.pn@granithotels.sk';
}

$robot = $_POST['first_name'];
$curl = $_POST['url'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$room = $_POST['room'];
$person = $_POST['person'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];
$lang = $_POST['lang'];
$url = "http://$_SERVER[HTTP_HOST]";
if($robot=='' && $name!='' && $surname!='' && $check_in!='' && $check_out!='' && $hotel!=''){
  if($email=='' && $phone==''){
    header('Location: '.$url.'/booking/?booking_error=required');
  }else{
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO form (hotel,check_in,check_out,room,person,name,surname,phone,email,message,lang,url)
    VALUES ('".$hotel."', '".$check_in."', '".$check_out."', '".$room."', '".$person."', '".$name."', '".$surname."', '".$phone."', '".$email."', '".$message."', '".$lang."', '".$curl."')";

    if($conn->query($sql) === TRUE){
      header('Location: '.$url.'/thank-you');
    }else{
      header('Location: '.$url.'/booking/?booking_error=conn');
    }

    $conn->close();

    if($email!=''){
      $headers = "From: ".$tomail."\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=Windows-1250\r\n";
      mail($tomail, 'Objednávka rezervácie ubytovania: '.$name.' '.$surname.' <'.$email.'>', '<table border="1" cellpadding="5" cellspacing="0">'
      .'<tr><td>Meno:</td><td>'.$name.'</td></tr>'
      .'<tr><td>Priezvisko:</td><td>'.$surname.'</td></tr>'
      .'<tr><td>Telefón:</td><td>'.$phone.'</td></tr>'
      .'<tr><td>E-mail:</td><td>'.$email.'</td></tr>'
      .'<tr><td>Hotel:</td><td>'.$hotel.'</td></tr>'
      .'<tr><td>Check in:</td><td>'.$check_in.'</td></tr>'
      .'<tr><td>Check out:</td><td>'.$check_out.'</td></tr>'
      .'<tr><td>Počet izieb:</td><td>'.$room.'</td></tr>'
      .'<tr><td>Počet osôb:</td><td>'.$person.'</td></tr>'
      .'<tr><td>Jazyk stránky:</td><td>'.$lang.'</td></tr>'
      .'<tr><td>Prišiel z:</td><td><a href="'.$curl.'" target="_blank">'.$curl.'</a></td></tr>'
      .'<tr><td colspan="2">Zvláštne požiadavky/poznámka:</td></tr><tr><td colspan="2">'.$message.'</td></tr>'
      .'</table>', $headers);
    }else{
      $headers = "From: ".$tomail."\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=Windows-1250\r\n";
      mail($tomail, 'Objednávka rezervácie ubytovania: '.$name.' '.$surname, '<table border="1" cellpadding="5" cellspacing="0">'
      .'<tr><td>Meno:</td><td>'.$name.'</td></tr>'
      .'<tr><td>Priezvisko:</td><td>'.$surname.'</td></tr>'
      .'<tr><td>Telefón:</td><td>'.$phone.'</td></tr>'
      .'<tr><td>Hotel:</td><td>'.$hotel.'</td></tr>'
      .'<tr><td>Check in:</td><td>'.$check_in.'</td></tr>'
      .'<tr><td>Check out:</td><td>'.$check_out.'</td></tr>'
      .'<tr><td>Počet izieb:</td><td>'.$room.'</td></tr>'
      .'<tr><td>Počet osôb:</td><td>'.$person.'</td></tr>'
      .'<tr><td>Jazyk stránky:</td><td>'.$lang.'</td></tr>'
      .'<tr><td>Prišiel z:</td><td><a href="'.$curl.'" target="_blank">'.$curl.'</a></td></tr>'
      .'<tr><td colspan="2">Zvláštne požiadavky/poznámka:</td></tr><tr><td colspan="2">'.$message.'</td></tr>'
      .'</table>', $headers);
    }
  }
}else{
  header('Location: '.$url.'/booking/?booking_error=required');
}
?>