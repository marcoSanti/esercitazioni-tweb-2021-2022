<?php

//questa variabile definisce cosa verrà ritornato agli utenti come errore...
//se true vengono mostrati gli errori a db, altrimenti viene mostrato un errore generico
define("__DEBUG__", TRUE);

$host = "localhost";
$port = 3306;
$dbname = "UniShare";
$dbUser = "root";
$dbPass = "";

try{
    $conn = new PDO("mysql:dbname=$dbname;host=$host:$port", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    header("Content-Type: text/javascript");
    echo json_encode($e);
    exit();
}

?>