<?php
$servername = "localhost";  
$username = "root";          
$password = "";             
$dbname = "book_table";  

$conn = new mysqli($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}
else{
    echo "Connected successfully";
}

?>
