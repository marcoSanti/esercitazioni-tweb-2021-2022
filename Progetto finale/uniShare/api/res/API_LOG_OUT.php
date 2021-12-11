<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Se login ok allora espone username = la email nella variabile $_SESSION
 * */

function logout(array $payload, PDO $conn){
   if(isset($_SESSION["username"])){
       unset($_SESSION["username"]);
       session_destroy();
       session_start();
       echo json_encode(Array("ok"=>"User logged out"));
   }else{
       echo json_encode(Array("ok"=>"User was not logged in"));
   }
}