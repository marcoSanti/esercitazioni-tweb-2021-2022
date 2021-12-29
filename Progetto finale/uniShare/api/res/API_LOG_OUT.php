<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api provvede a effettuare il login dell'utente andado a rimuovere la variabile $_SESSION["username"]
 * */

function logout(array $payload, PDO $conn){
   if(isset($_SESSION["username"])){
        unset($_SESSION["username"]);
        session_destroy();
        session_start();
        jsonEcho("ok", "User logged out");
   }else{
        jsonEcho("ok", "User was not logged in");
   }
}