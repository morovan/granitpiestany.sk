<?php

$servername = "localhost";
$username = "granit";
$password = "visi0579";
$dbname = "granit";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}
        
$sql = "SELECT meta_key, meta_value, post_id FROM gr_postmeta";
$result = $conn->query($sql);

if($result->num_rows > 0){
  while($row = $result->fetch_assoc()){
    if($row["meta_key"]=='offer_date_to'){
      if($row["meta_value"]!=''){
        if($row["meta_value"] == date("Ymd")){
          $key=$row["post_id"];
        }
      }
    }
  }
}

$sql1 = "UPDATE gr_posts SET post_status= 'trash' WHERE ID=$key";
if($conn->query($sql1)===TRUE){
}

$conn->close();
    
?>