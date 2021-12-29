<?php


/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api prepara i dati per poter essere visualizzati dal grafico degli appunti
 * acquistati in base alla materia nella dashboard
 * esistono due colonne dell'array che viene ritornato:
 * values: i valori numerici,
 * labels: le labels dei numeri
 * */



function getChartNotes(array $payload, PDO $conn)
{

    loginCheck();
   
        try {
            
            $retArray["values"] = Array();
            $retArray["labels"] = Array();

            $stmtGetCount = $conn->prepare("SELECT count(1) as 'values', insegnamento.Nome as labels 
                                            from 
                                                (appunti INNER join acquisto ON appunti.idappunti = acquisto.appunto) 
                                                inner JOIN insegnamento on appunti.insegnamento_scuola = insegnamento.idInsegnamento 
                                            where acquisto.user = :user group by insegnamento_scuola;");
                                            
            $stmtGetCount->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmtGetCount->execute();
            
            while($row = $stmtGetCount->fetch(PDO::FETCH_ASSOC)){
                $retArray["values"][] = $row["values"];
                $retArray["labels"][] = $row["labels"];
            }

            echo json_encode($retArray);
        } catch (PDOException $e) { jsonReturnEcho(500, "Error", $e); }

    }


