<?php
/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna i docenti presenti a db
 * */

function getTeachers(array $payload, PDO $conn){

    loginCheck();
        $sql = "SELECT distinct nomeDocente as item FROM appunti ";
        try{
            $return = array();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($res as $row){
                $return[]["item"] = $row["item"];
            }
            echo json_encode($return);
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    }