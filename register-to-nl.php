<?php
$servername = "localhost";
$dbname   = "granit";
$username = "granit";
$password = "visi0579";


$curl = $_GET['fromurl'];

$email = $_GET['email'];
$lang = $_GET['lang'];
$url = "http://$_SERVER[HTTP_HOST]";
if($email!=''){
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO nl (email,lang,url)
  VALUES ('".$email."', '".$lang."', '".$curl."')";

  if($conn->query($sql) === TRUE){
    header('Location: '.$url.'/thank-you-2');
  }else{
    header('Location: '.$url.'/booking/?booking_error=conn');
  }

  $conn->close();
}else{
  header('Location: '.$url.'/booking/?booking_error=required');
}
?>