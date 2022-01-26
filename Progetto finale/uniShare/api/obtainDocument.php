<?php

/*
 * Con questa pagina ritorno un documento di una nota acquistata. il documento avrà il nome generico document.pdf
 * e non vi saranno tracce del nome salvato a database.
 * Nota: non faccio il controllo se il file non esiste così
 * evito di esporre potenziali informazioni a utenti malintenzionati
 * */


session_start();

if(!isset($_SESSION["username"])){
    http_response_code(400);
    exit();
}

if(!isset($_GET["doc"])){
    http_response_code(400);
    exit();
}

if(!@require_once "config.php"){
    http_response_code(500);
    exit();
}

$doc = $_GET["doc"];

$stmtGetDocument = $conn->prepare("SELECT * FROM appunti inner join acquisto on appunti.idappunti = acquisto.appunto WHERE acquisto.user = :username AND appunti.Nome = :document; ");
$stmtGetDocument->bindValue(":username", $_SESSION["username"], PDO::PARAM_STR);
$stmtGetDocument->bindValue(":document", $doc, PDO::PARAM_STR);
$stmtGetDocument->execute();

if($stmtGetDocument->rowCount() != 0){
    //controllo se utente è admin. se lo è allora l'admin può scaricare il documento a prescindere
    $stmtCheckAdmin = $conn->prepare("SELECT * from users where email = :mail");
    $stmtCheckAdmin->bindValue(":mail", $_SESSION["username"], PDO::PARAM_STR);
    $stmtCheckAdmin->execute();
    if($stmtCheckAdmin->rowCount()!=1){
        http_response_code(403);
        exit();
    }
}

//header presi da pagina manuale php di readfile
header('Content-Description: File Transfer'); //forzo il download invece di una navigazione a una pagina generica
header("Content-type:application/pdf"); //tipo di file
header('Content-Disposition: attachment; filename=document.pdf');//il nome che la pagina avà quando ottengo il documento
header('Content-Length: ' . filesize("../uploads/".$doc.".pdf")); //la dimensione del file da scaricare
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();
readfile("../uploads/".$doc.".pdf"); //ritorno il contenuto del file
