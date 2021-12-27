<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna il tipo di utente (user o admin) dell'utente attualmente loggato
 * */

function getUserType(array $payload, PDO $conn){

    loginCheck();
        try{
            $stmt = $conn->prepare("SELECT UserType FROM Users WHERE email = :mail");
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $userType = $stmt->fetch(PDO::FETCH_ASSOC)["UserType"];
            if($userType == 1){
                jsonEcho("UserType", "ADMIN");
            }else{
                jsonEcho("UserType", "USER");
            }
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    
}