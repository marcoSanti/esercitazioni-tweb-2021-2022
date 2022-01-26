<?php

/*
 * parametri richiesti in payload:
 * query
 *
 * Questa api ritorna le vendite per ogni utente
 * */


function getSales(array $payload, PDO $conn){

    loginCheck();

        try{
            $return = Array();
            $stmtGetUserSale = $conn->prepare("SELECT  idappunti as codice, Nome as titolo, uploadDate, price, insegnamento_scuola as insegnamento, tipoAppunti, nomeDocente as docente, visible  from appunti where user = :user;");
            $stmtGetUserSale->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmtGetUserSale->execute();

            while(($row  = $stmtGetUserSale->fetch(PDO::FETCH_ASSOC)) != null){
                $stmtGetEarnings = $conn->prepare("SELECT count(user) as cnt from acquisto where appunto = :idAppunto;");
                $stmtGetEarnings->bindValue(":idAppunto", $row["codice"], PDO::PARAM_INT);
                $stmtGetEarnings->execute();
                $count = $stmtGetEarnings->fetch(PDO::FETCH_ASSOC)["cnt"];

                //convert count to effective earnings
                $row["earnings"]  = 2*($count * $row["price"])/3;
                $return[] = $row;
            }
            echo json_encode($return);
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}

    }


