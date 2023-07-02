<?php
$servername = "localhost";  // Replace with your MySQL server name or IP address
$username = "user1"; // Replace with your MySQL username
$password = "password"; // Replace with your MySQL password
$database = "test"; // Replace with your MySQL database name


// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //echo " failed";
}


$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
//$conn->close();

?>
