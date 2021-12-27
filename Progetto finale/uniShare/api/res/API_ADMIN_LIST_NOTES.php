<?php


/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna gli utenti del sito
 * */


function listDocuments(array $payload, PDO $conn)
{

    loginCheck();

        try {

            admin_check($conn);

            $return = array();
            $stmtGetUsers = $conn->prepare("SELECT idappunti, nome, user, Path, price from appunti");
            $stmtGetUsers->execute();

            while (($row = $stmtGetUsers->fetch(PDO::FETCH_ASSOC)) != null) {
                $return[] = $row;
            }
            echo json_encode($return);
        } catch (PDOException $e) { jsonReturnEcho(500, "Error", $e); }

    }


