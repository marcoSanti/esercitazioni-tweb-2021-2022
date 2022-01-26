<?php
/*
 * parametri richiesti in payload:
 * -email
 * -password
 *
 * Se login ok allora espone username = la email nella variabile $_SESSION
 * */

function login(array $payload, PDO $conn){
    $username = $payload["email"];
    $password = hash("sha512", $payload["password"]);

    if(isset($_SESSION["username"])){
        jsonEcho("Ok", "Logged");
    }else{
        try{
            $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :mail AND password = :password");
            $stmt->bindValue(":mail", $username, PDO::PARAM_STR);
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()==1){
                session_destroy();
                session_start();
                $_SESSION["username"] = filter_var($username, FILTER_VALIDATE_EMAIL);
                jsonEcho("Ok", "Logged");
            }else{
                jsonEcho("Error", "Username o password errati");
            }
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    }
}