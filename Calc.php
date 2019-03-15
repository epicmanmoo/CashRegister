<html>
<html lang= "en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php


$user= 'root';
$pass= '';
$host= 'localhost';
$db= 'calculate'; //add this after creating databse, name of database

$db= new mysqli($host, $user, $pass, $db) or die ("Error"); //connects to my database
//Creates the database cuz im too lazy
// $createDB= "CREATE DATABASE calculate";
// if(mysqli_query($db, $createDB) == true){
//   echo "Database Created";
// }
//Creates table inside databse cuz im too lazy
// $addTables= "CREATE TABLE items (itemID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, //UNSIGNED is good if there are no negative values
//              itemName VARCHAR(30) NOT NULL,
//              itemPrice FLOAT(5) NOT NULL)";
// if(mysqli_query($db, $addTables) == true){
//   echo "Tables Added";
// }
//now i insert stuff to databse
if($_SERVER["REQUEST_METHOD"] == "POST"){ //it has the request method, which is post
  if(isset($_POST["itemName"]) and isset($_POST["itemPrice"]) and isset($_POST["quantity"])){ //isset checks to see if value is set or not, returns null if field is empty, pretty cool
    $itemName= $_POST["itemName"];
    $itemPrice= $_POST["itemPrice"];
    $quantity= $_POST["quantity"];
    if(!(empty($itemName)) and !(empty($itemPrice)) and !(empty($quantity)) and !(empty(trim($itemName))) and !(empty(trim($itemPrice))) and !(empty(trim($quantity)))){
      if(is_numeric($itemPrice) and is_numeric($quantity) and !(is_numeric($itemName))){
        $checkDuplicate= "SELECT itemName FROM items WHERE itemName= '$itemName'";
        $resultDuplicate= $db->query($checkDuplicate);
          if($resultDuplicate->num_rows != 0){
            $updateItem= "UPDATE items SET quantity= $quantity, itemPrice= $itemPrice WHERE itemName= '$itemName'";
              if(mysqli_query($db, $updateItem) == true){
                echo "Updated " . $itemName;
              }
            }
          else{
            $insertName= "INSERT INTO items(itemName, itemPrice, quantity) VALUES ('$itemName', '$itemPrice', '$quantity')";
              if(mysqli_query($db, $insertName) == true){
                echo "Added " . $itemName;
              }
            }
          }
          else{
            echo "One or more fields are incorrectly filled";
          }
        }
        else{
          echo "Fields must be completed";
        } // TODO: add an option to make seperate lists to have quantity, weight, etc. make fields better, nicer page, etc.
      }
    }
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method= "post"> <!-- htmlspecialchars($_SERVER["PHP_SELF"]) is some weird thing preventing hackers to steal sensitive data and changes URL -->
  <label id= "itemName" for="in">Item Name: </label>
  <input type="text" name= "itemName" id="intext" placeholder="Enter item name" maxlength="20"></input><br>
  <label id= "itemPrice" for="ip">Item Price: </label>
  <input type="text" name= "itemPrice" id="iptext" placeholder="Enter item price" maxlength="20"></input><br>
  <label id= "quantity" for="q">Quantity: </label>
  <input type="text" name= "quantity" id="qtext" placeholder="Enter quantity" maxlength="20"></input><br>
  <button type="submit" value= "Submit" class="btn btn-info">Submit</button>
</form>

  <li><a href="http://localhost/Show.php" data-toggle="tooltip" data-placement="bottom" title="Main">Results</a></li>

</body>
</html>
