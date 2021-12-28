<?php


/*
 * parametri richiesti in payload:
 * nil
 *
 * Questa api ritorna gli utenti del sito
 * */



function getCash(array $payload, PDO $conn)
{

    loginCheck();
   
        try {
            admin_check($conn);

            $stmtGetCashflow = $conn->prepare("SELECT SUM( price ) AS prezzo FROM acquisto INNER JOIN appunti ON (acquisto.appunto = appunti.idappunti);");
            $stmtGetCashflow->execute();

            $result = $stmtGetCashflow->fetch(PDO::FETCH_ASSOC)["prezzo"];

            echo json_encode(Array("in"=>round($result/3, 2), "out"=>round($result*2/3, 2)));
        } catch (PDOException $e) { jsonReturnEcho(500, "Error", $e); }

    }


