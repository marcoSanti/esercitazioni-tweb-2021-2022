/**
 * Questa funzione va a registrare un utente. se l'utente è registrato,
 * viene rimandato alla homepage. al contrario viene mostrato un errore
 */
function register() {
    var nome = $("#InputNome").val();
    var cognome = $("#InputCognome").val();
    var email = $("#InputEmail").val();
    var password1 = $("#InputPassword1").val();
    var password2 = $("#InputPassword2").val();

    if (nome === "" || cognome === "" || email === "" || password1 === "" || password2 === "") {
        showAlert("danger", "Attenzione", "Inserire tutte le informazioni richieste");
        return;
    }

    if (password2 != password1) {
        showAlert("danger", "Errore", "Le password non coincidono!");
        return;
    }

    if (!validateMail(email)) {
        showAlert("danger", "Errore", "Le password non coincidono");
        return;
    }

    ajaxCall("sign_up", { "name": nome, "surname": cognome, "email": email, "password": password1 }, function(data) {
        if (data["Ok"] !== undefined) {
            window.location.href = "./";
        } else {
            showAlert("danger", "Errore", data["Error"]);
        }
    });
}

/**
 * dopo aver aggiunto l'handler, viene bindato il tasto enter alla funzione register
 */
$(function() {
    $("#RegisterFormSubmit").click(register);
}).keypress(function(e) {
    var key = e.which;
    if (key == 13) // pulsante invio
    {
        register();
    }
});