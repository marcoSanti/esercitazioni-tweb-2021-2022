<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna la dashboard
 * */

function getUserDashboard(array $payload, PDO $conn){

    if(!isset($_SESSION["username"])){
        echo json_encode(Array("Error"=>"User not logged in"));
        exit();
    }else{
        $sql = "SELECT obj1, obj2, obj3, obj4 FROM dashboard WHERE user = :mail";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}