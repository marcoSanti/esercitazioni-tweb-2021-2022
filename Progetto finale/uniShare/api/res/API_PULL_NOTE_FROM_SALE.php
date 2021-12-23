<?php

/*
 * parametri richiesti in payload:
 * codice
 * pull : 1 o 0 (se 1 la nota viene tolta dalla vendita altrimenti viene messo in vendita)
 *
 * Questa api ritorna le vendite per ogni utente
 * */


function pullFromSale(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else {
        if(!isset($payload["pull"]) || !isset($payload["codice"])){
            http_response_code(400);
            echo json_encode(Array("Error"=>"Missing parameters"));
            exit();
        }
        try{
            $stmtGetNote = $conn->prepare("SELECT * from appunti WHERE user = :username AND idappunti = :id;");
            $stmtGetNote->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
            $stmtGetNote->bindValue(":id", $payload["codice"], PDO::PARAM_STR);
            $stmtGetNote->execute();
            if($stmtGetNote->rowCount() ==1){
                $stmtUpdatePull = $conn->prepare("UPDATE appunti SET visible = :status WHERE idappunti = :id");
                $stmtUpdatePull->bindValue(":id", $payload["codice"], PDO::PARAM_STR);
                if($payload["pull"]==1){
                    $stmtUpdatePull->bindValue(":status", 0, PDO::PARAM_STR);
                }else{
                    $stmtUpdatePull->bindValue(":status",1, PDO::PARAM_STR);
                }
                $stmtUpdatePull->execute();
                echo json_encode(Array("Ok"=>"done"));
            }


        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }

    }

}
