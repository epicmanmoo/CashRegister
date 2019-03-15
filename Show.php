<html>
<html lang= "en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<style>


table{
border-collapse: collapse;
text-align: center;
margin:auto;
width:15%;
}
th, td{
border: 1px solid black;
}
tr:hover td{
background-color: silver;
}
#totalCostTextColor{
color: red;
}
#deleteItemButton{
  float: right;
  width: 60px;
  height: 30px;
  border: none;
  outline: none; /*no outline (as in there is no effect on the button animation when clicking)*/
}

</style>

<body>


<?php


$user= 'root';
$pass= '';
$host= 'localhost';
$db= 'calculate';
$db= new mysqli($host, $user, $pass, $db) or die ("Error");
$select= "SELECT itemID, itemName, ROUND(itemPrice, 2), quantity FROM items";
$sum= "SELECT ROUND(SUM(itemPrice*quantity), 2) FROM items";
$result= mysqli_query($db, $select);
$sumResult= mysqli_query($db, $sum);
$numRows= $result->num_rows;
if($numRows >= 0){
  echo "<table class='table table-hover'><tr><th><center>Name</center></th><th><center>Price</center></th></tr>"; //1. idk why i did this but it prints the table to the page
  while($row= $result->fetch_assoc()){ //fetch_assoc() fetches result in each row as an associative array (converts the array to string so i can print)
    echo "<div id= 'showNameOnDelBtn' style='display: none;'>" . htmlspecialchars($row["itemName"]) . "</div>";
    if($row["quantity"] > 1){
      echo "<tr><td>" . $row["itemName"] . "</td><td>$" . $row["ROUND(itemPrice, 2)"] . " (" . $row["quantity"] . ")" . "<form id= 'delForm' action='doDelete.php' method= 'post'><input type= 'hidden' name= 'del' value= '$row[itemName]'><input type='submit' onclick= 'alertDelBtn()' value= 'Delete' id= 'deleteItemButton'></form></td></tr>";//goto 1
    }
    else{
      echo "<tr><td>" . $row["itemName"] . "</td><td>$" . $row["ROUND(itemPrice, 2)"] . "<form id= 'delForm' action='doDelete.php' method= 'post'><input type= 'hidden' name= 'del' value= '$row[itemName]'><input type='submit' onclick= 'alertDelBtn()' value= 'Delete' id= 'deleteItemButton'></form></td></tr>";//goto 1
    }
}
  if($row2= $sumResult->fetch_assoc()){ //used if statement cuz i know only one row will return for total
    $totalRowLOL= "<tr><td id= 'totalCostTextColor'> Total </td><td>";
    $totalRowLOOL= "</tr></table>";
    if($row2["ROUND(SUM(itemPrice*quantity), 2)"] == 0){
      echo $totalRowLOL . "$0" . $totalRowLOOL;
    }
    else{
      echo $totalRowLOL . "$" . $row2["ROUND(SUM(itemPrice*quantity), 2)"] . $totalRowLOOL;
  }
  }
}

?>

<li><a href="http://localhost/Calc.php" title="Main">Main</a></li>


</body>
</html>
