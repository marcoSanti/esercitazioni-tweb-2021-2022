<?php

/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna le università a db
 * */
function getBoughtNotes(array $payload, PDO $conn){

    loginCheck();
 
        try{
            $retElement = Array();
            $stmt = $conn->prepare("SELECT idappunti as codice, Nome as titolo, uploadDate, price as prezzo, insegnamento_scuola as insegnamento, tipoAppunti, nomeDocente as docente, Path ,ID_acquisto from appunti inner join acquisto on acquisto.appunto = appunti.idappunti where acquisto.user = :user;");
            $stmt->bindValue(":user",$_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
            while($item = $stmt->fetch(PDO::FETCH_ASSOC)){
                $stmtCheckReview = $conn->prepare("SELECT * FROM recensione WHERE acquisto = :acquisto");
                $stmtCheckReview->bindValue(":acquisto", $item["ID_acquisto"], PDO::PARAM_INT);
                $stmtCheckReview->execute();
                
                $item["reviewed"] = ($stmtCheckReview->rowCount()>0);
                
                $retElement[] = $item;
            }

            echo json_encode($retElement);
            
        }catch (PDOException $e){jsonReturnEcho(500, "Error", $e);}
    
}