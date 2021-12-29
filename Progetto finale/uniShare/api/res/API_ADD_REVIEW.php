<?php


/*
 * parametri richiesti in payload:
 * note: id appunto della recensione
 * value: valore della recensione
 *
 * questa api permette di inserire una recensione di un prodotto. la query deve essere fatta in 3 parti 
 * in quanto nella prima select controllo che le righe siano !=0  (ho acquistato il prodotto)
 * e nella seconda query controllo che siano uguali a 0 (non ho ancora recensito il prodotto).
 * se queste due condizioni sono verificate, allora procedo all'inseriemtno della recensione
 * */


function insertReview(array $payload, PDO $conn)
{

    loginCheck();
        if($payload["value"]>5 || $payload["value"]<0){
            jsonReturnEcho(400, "Error", "review value out of bounds!");
        }
        try{
            $stmtAcquisto = $conn->prepare("SELECT * from acquisto where user = :user and appunto = :appunto");
            $stmtAcquisto->bindValue(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmtAcquisto->bindValue(":appunto",$payload["note"], PDO::PARAM_INT);
            $stmtAcquisto->execute();
            
            if($stmtAcquisto->rowCount()==0){
                jsonReturnEcho(400, "Error", "Item was not bought");
            }

            $resultStmtAcquisto =  $stmtAcquisto->fetch(PDO::FETCH_ASSOC);
    
           //controllo che non ho a database una recensinoe già effettuata
            $stmtCheckRecensione = $conn->prepare("SELECT * FROM recensione where appunto = :appunto and acquisto = :acquisto");
            $stmtCheckRecensione->bindValue(":appunto", $payload["note"], PDO::PARAM_INT);
            $stmtCheckRecensione->bindValue(":acquisto", $resultStmtAcquisto["ID_acquisto"], PDO::PARAM_INT);
            $stmtCheckRecensione->execute();
            if($stmtCheckRecensione->rowCount()==0){
                $stmtInsertRecensione = $conn->prepare("INSERT INTO recensione (valore, appunto, acquisto) VALUES (:valore, :appunto, :acquisto)");
                $stmtInsertRecensione->bindValue(":valore", $payload["value"], PDO::PARAM_INT);
                $stmtInsertRecensione->bindValue(":appunto", $payload["note"], PDO::PARAM_INT);
                $stmtInsertRecensione->bindValue(":acquisto", $resultStmtAcquisto["ID_acquisto"], PDO::PARAM_INT);
                $stmtInsertRecensione->execute();
                jsonReturnOkEcho();
                
            }else{
                jsonReturnEcho(400, "Error", "Item already reviewed");
            }
        }catch(PDOException $e){ jsonReturnEcho(500, "Error", $e); }
       

}