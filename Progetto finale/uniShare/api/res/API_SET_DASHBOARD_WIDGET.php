<?php
/*
 * parametri richiesti in payload:
 * -position
 * -widget
 * */

function setDashboardWidget(array $payload, PDO $conn){

    $widget = $payload["widget"];

    if($payload["position"]<1 || $payload["position"]>4){
        http_response_code(500);
        echo json_encode(Array("Error"=>"Unknown position"));
        exit();
    }

    /*
     * non uso $stmt->bindValue() in quanto viene generato un errore di type mismatch dal server sql
     * */
    $obj = "obj" . filter_var($payload["position"], FILTER_SANITIZE_NUMBER_INT);

    if(isset($_SESSION["username"])){
        $sql = "UPDATE dashboard SET $obj = :widget WHERE user = :user;";
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->bindValue(":widget", $widget, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(Array("Ok"=>"Updated"));
        }catch (PDOException $e){
            http_response_code(500);
            echo json_encode(Array("Error"=>$e));
            exit();
        }
    }
}