/*
 * funzione wrapper del metodo ajax.
 * payload è un oggetto json
 * whendone deve accettare come risultato data che è l'output del server
 * whenError è la funzione che viene eseguita in caso di errore.
 * */
function ajaxCall(api, payload, whenDone = function() {}, whenError = function(data) { console.log(data) }) {
    var sendData = JSON.stringify({ "api": api, "payload": payload });
    $.ajax("./api/index.php", {
        data: sendData,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'text'
    }).done(function(data, status) {
        var obj = JSON.parse(data);
        whenDone(obj);
    }).fail(function(data, status) {
        console.log(sendData);
        whenError(data);
    });
}


/*
funzione per mostrare messaggi di informazione all'utente
aggiunge un div e poi dopo 3 secondi lo rimuove
*/
function showAlert(type, title, message) {
    $("#BannerContainerViewer").html("<div class='alert alert-" + type + " alert-dismissible fade show' role='alert'>" +
        "<strong>" + title + "</strong> " + message +
        "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>").show().delay(3000).fadeOut();
}

/**
 * Questa funzione controlla che la email inserita rispetti i criteri delle email.
 * Espressione regolare presa da: RFC2822 e in particolare https://gist.github.com/gregseth/5582254 (by sonyarianto  on 8 Nov)
 * Questa espressione regolare accetta anche indirizzi email con utf-8
 * 
 * @param {*} mail email da controllare 
 * @returns se l'email è valida o meno
 */
function validateMail(mail) {
    return mail.toLowerCase().match(
        /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g
    );
}

/**
 * Questa funzione controlla che l'utente sia loggato e se non lo 
 * è viene rimandato alla pagina di login
 */
function userLoginCheck() {
    //se utente non è loggato faccio un redirect a login
    ajaxCall("log_in_check", {}, function(data) {
        if (data["Status"] === undefined || data["Status"] !== "logged") {
            window.location.href = "./login";
        }
    });
}