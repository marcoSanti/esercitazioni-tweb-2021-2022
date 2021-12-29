/**
 * questa funzione verifica il login. se ha successo, viene rimandato alla home page altrimenti viene 
 * mostrato un messaggio di errore
 * @returns 
 */

function login() {
    var email = $("#LoginEmail").val();
    var password = $("#LoginPassword").val();
    if (email === "" || password === "") {
        showAlert("danger", "Errore", "Username e/o password non possono essere lasciati vuoti!");
        return;
    }


    if (!validateMail(email)) {
        showAlert("danger", "Errore", "Indirizzo email non valido!");
        return;
    }

    ajaxCall("log_in", { "email": email, "password": password }, function(data) {
        if (data["Ok"] !== undefined) {
            window.location.href = "./user.shtml";
        } else {
            showAlert("danger", "Errore", "Credenziali di accesso errate o non esistenti");
        }
    });

}

/**
 * questa funzione aggiunge gli handler quando la pagina è caricata, infine binda il tasto enter
 * alla funzione login
 */
$(function() {
    $("#loginButton").click(login);
}).keypress(function(e) {
    var key = e.which;
    if (key == 13) // pulsante invio
    {
        login();
    }
});