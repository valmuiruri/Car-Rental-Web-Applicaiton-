<?php

$host = "localhost";
$db_name = "ktcs";
$username = "root"; // use your own username and password if different from mine
$password = "";

try {
    $dbh = new mysqli($host,$username,$password, $db_name);

}
 /*
try {
   Create a connection with the database $dbh = null;
   $dbh = new PDO('mysql:host=localhost;dbname=KTCS', 'admin', 'password');*/

   /* Turn on error checking  
   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


   
die();

} */catch (Exception $e) {
      echo $e->getMessage();
      
}

?>
