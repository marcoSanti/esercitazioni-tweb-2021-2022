<?php


/*
 * parametri richiesti in payload:
 *
 * noteId: id dell'appunto da elminare
 * 
 * Questa api provvede a eliminare un appunto dal server andando a rimuovere prima
 * tutti i riferimenti in altre tabelle del db che referenziano la nota.
 * La conseguenza è che tutte le recensioni e gli acquisti relativi a questa nota vengono
 * rimossi anche dagli account degli altri utenti.
 * Per questo motivo un utente non può eliminare una nota ma solo rimuoverla dalla vendita
 * */


function deleteNote(array $payload, PDO $conn)
{
    loginCheck();

        try{

            admin_check($conn);

            //elimino il file
            $stmtGetFileName = $conn->prepare("SELECT path from appunti where idappunti = :id");
            $stmtGetFileName->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtGetFileName->execute();
            $path = $stmtGetFileName->fetch(PDO::FETCH_ASSOC)["path"];
            unlink("../uploads/" . $path . ".pdf");

            //elimino tutti i dati a db
            $stmtDeleteNote = $conn->prepare("DELETE FROM recensione where appunto = :appunto; 
                                              DELETE FROM acquisto WHERE appunto = :appunto;
                                              DELETE FROM appunti WHERE idappunti = :id;");
                                              
            $stmtDeleteNote->bindValue(":appunto", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteNote->bindValue(":id", $payload["noteId"], PDO::PARAM_INT);
            $stmtDeleteNote->execute();


            jsonReturnOkEcho();

        }catch(PDOException $e){ jsonReturnEcho(500, "Error", $e); }
    }
