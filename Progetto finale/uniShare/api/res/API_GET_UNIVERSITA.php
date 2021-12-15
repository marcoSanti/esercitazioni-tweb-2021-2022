<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna le università a db
 * */

function apiElencaUniversita(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else{
        $sql = "SELECT nomeScuola as item FROM scuola ";
        try{
            $return = array();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($res as $row){
                $return[]["item"] = $row["item"];
            }
            echo json_encode($return);
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}