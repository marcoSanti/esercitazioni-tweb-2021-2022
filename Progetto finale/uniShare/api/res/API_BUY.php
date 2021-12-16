<?php
/*
 * parametri richiesti in payload:
 * productId
 *
 * Questa api ritorna le università a db
 * */

function buy(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else{
        $sql = "insert into acquisto (user, appunto) VALUES (:username, :appunto);";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":appunto", $payload["productId"], PDO::PARAM_STR);
            $stmt->bindValue(":username",$_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();

            echo json_encode(Array("Ok"=>"Inserted!"));
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}