<?php
$host = "localhost";
$port = 3306;
$dbname = "UniShare";
$dbUser = "root";
$dbPass = "";
try{
    $conn = new PDO("mysql:dbname=$dbname;host=$host:$port", $dbUser, $dbPass);
}catch(PDOException $e){
    header("Content-Type: text/javascript");
    echo json_encode($e);
    exit();
}