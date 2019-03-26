<?php

$user= 'root';
$pass= '';
$host= 'localhost';
$db= 'calculate';
$db= new mysqli($host, $user, $pass, $db) or die ("Error");
if(isset($_POST['del'])){
  $id= $_POST['del'];
  $delete= "DELETE FROM items WHERE itemName= '$id'";
  mysqli_query($db, $delete);
  echo "<meta http-equiv= 'refresh' content='0; url=Show.php'>";
}
else{
  echo "error";
}

?>
