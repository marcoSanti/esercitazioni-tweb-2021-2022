<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna il tipo di utente (user o admin) dell'utente attualmente loggato
 * */

function getUserType(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else{
        $sql = "SELECT UserType FROM Users WHERE email = :mail";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $userType = $stmt->fetch(PDO::FETCH_ASSOC)["UserType"];
            if($userType == 1){
                echo json_encode(Array("UserType"=>"ADMIN"));
            }else{
                echo json_encode(Array("UserType"=>"USER"));
            }
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}