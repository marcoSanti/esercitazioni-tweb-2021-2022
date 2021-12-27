<?php


/*
 * parametri richiesti in payload:
 *
 * noteId: id dell'appunto da elminare
 * 
 * Questa api ritorna gli utenti del sito
 * */


function deleteNote(array $payload, PDO $conn)
{
    loginCheck();

        try{

            admin_check($conn);

            
            $stmtDeleteReviews = $conn->prepare("DELETE FROM recensione where appunto = :appunto");
            $stmtDeleteReviews->bindValue(":appunto", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteReviews->execute();

            $stmtDeleteAcquisto = $conn->prepare("DELETE FROM acquisto WHERE appunto = :appunto");
            $stmtDeleteAcquisto->bindValue(":appunto", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteAcquisto->execute();

            $stmtGetFileName = $conn->prepare("SELECT path from appunti where idappunti = :id");
            $stmtGetFileName->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtGetFileName->execute();
            $path = $stmtGetFileName->fetch(PDO::FETCH_ASSOC)["path"];
            unlink("../uploads/" . $path . ".pdf");

            $stmtDeleteNote = $conn->prepare("DELETE FROM appunti WHERE idappunti = :id");
            $stmtDeleteNote->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteNote->execute();

            jsonReturnOkEcho();

        }catch(PDOException $e){ jsonReturnEcho(500, "Error", $e); }
    }
