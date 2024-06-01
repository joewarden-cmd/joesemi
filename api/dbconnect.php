<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "antisocial_db";

try {
    $conn = new PDO("mysql:host=$servername;
    dbname=$database",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
}catch (PDOException $th) {
    echo "Connection Failed:" .$th->getMessage();
}
?>