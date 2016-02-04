<?php
$frommail = 'nl@granithotels.sk';

$robot = $_POST['name'];
$curl = $_POST['url'];
$email = $_POST['email'];
$lang = $_POST['lang'];
$url = "http://$_SERVER[HTTP_HOST]";
$finalurl = $url.'/register-to-nl.php?email='.$email.'&fromurl='.$curl.'&lang='.$lang;

echo '<!DOCTYPE html><html lang="'.$lang.'"><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><title>Granit Newsletter</title>';
echo '<link href="https://fonts.googleapis.com/css?family=PT+Serif:400,700italic,700,400italic&subset=latin,latin-ext" rel="stylesheet" type="text/css">';
echo '<style type="text/css">body{margin:0;padding:5px 0 0 0;font-size:14px;line-height:1.4;font-family:"PT Serif","Palatino Linotype","Book Antiqua",Palatino,serif;color:#fff;}.podakovanie{color:#8fc74f;}.chybamail{color:#ff9d00;}</style></head><body>';

if($robot=='' && $email!=''){
  $headers = "From: ".$frommail."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=utf-8\r\n";
  mail($email,'Prihlásenie na odber newslettru spoločnosti Granit',
  'Dobrý deň,<br><br>'
  .'váš e-mail zažiadal o odber newslettru spoločnosti Granit.<br>'
  .'Pre potvrdenie registrácie prosím kliknite na tlačidlo:<br><br>'
  .'<a href="'.$finalurl.'" target="_blank" style="display:inline-block;padding:10px;color:#fff;background:#695B4E;border-radius:4px">Potvrdzujem registráciu na odber newslettru</a><br><br>'
  .'V prípade nefunkčnosti tlačídla, prosím skopírujte odkaz<br>'.$finalurl.'<br><br><br>'
  .'Na vašu e-mailovú adresu sa budú odosielať len newslettre spoločnosti Granit a neposkytne sa tretím stranám. Z odberu je možné sa kedykoľvek odhlásiť, pričom emailová adresa sa bezpečne z odberu vymaže.<br>'
  .'Ak ste dostali tento e-mail omylom, jednoducho ho vymažte. Nebudete prihlásení na odber, ak svoje prihlásenie nepotvrdíte kliknutím na vyššie uvedené tlačidlo.<br><br>'
  .'S pozdravom<br>Granit', $headers);
  echo '<span class="podakovanie">Ďakujeme. Kliknutím na odkaz v e-maile potvrdíte registráciu.</span>';
}else{
  echo '<span class="chybamail">Nevyplnili ste email.</span>';
}

echo '</body></html>';
?>