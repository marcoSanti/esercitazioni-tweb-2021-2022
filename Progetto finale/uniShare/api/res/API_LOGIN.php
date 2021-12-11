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
        echo json_encode(Array("Ok"=>"User already logged in"));
        exit();
    }else{
        $sql = "SELECT * FROM Users WHERE email = :mail AND password = :password";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":mail", $username, PDO::PARAM_STR);
            $stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()==1){
                session_destroy();
                session_start();
                $_SESSION["username"] = filter_var($username, FILTER_VALIDATE_EMAIL);
                echo json_encode(Array("Ok"=>"Logged"));
            }else{
                echo json_encode(Array("Error"=>"Wrong credentials"));
            }
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}