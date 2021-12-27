<?php

/*
 * parametri richiesti in payload:
 * nil
 *
 * */

function userIsLogged(array $payload, PDO $conn){
    if(isset($_SESSION["username"])){
        jsonEcho("Status", "logged");
    }else{
        jsonEcho("Status", "not_logged");
    }
}