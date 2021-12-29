<?php

/*
 * parametri richiesti in payload:
 * nil
 *
 * questa api ritorna lo stato dell'utente (loggato o meno)
 * */

function userIsLogged(array $payload, PDO $conn){
    if(isset($_SESSION["username"])){
        jsonEcho("Status", "logged");
    }else{
        jsonEcho("Status", "not_logged");
    }
}