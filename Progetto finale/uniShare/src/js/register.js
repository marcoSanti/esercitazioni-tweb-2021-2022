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
        $("#ErrorRegisterDivContent").html("Inserire tutti i campi!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    if (password2 != password1) {
        $("#ErrorRegisterDivContent").html("Le password non coincidono!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    if (!validateMail(email)) {
        $("#ErrorRegisterDivContent").html("L'indirizzo email non è valido!");
        $("#ErrorRegisterDiv").fadeIn();
        return;
    }

    ajaxCall("sign_up", { "name": nome, "surname": cognome, "email": email, "password": password1 }, function(data) {
        if (data["Ok"] !== undefined) {
            window.location.href = "./";
        } else {
            $("#ErrorLoginDivContent").html(data["Error"]);
            $("#ErrorLoginDiv").fadeIn();
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