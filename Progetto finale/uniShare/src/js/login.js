function login() {
    var email = $("#LoginEmail").val();
    var password = $("#LoginPassword").val();
    if (email === "" || password === "") {
        $("#ErrorLoginDivContent").html("Email e password non possono essere lasciati vuoti!");
        $("#ErrorLoginDiv").fadeIn();
        return;
    }

    /*
     * Questa funzione controlla che la email inserita rispetti i criteri delle email.
     * Espressione regolare presa da: RFC2822 e in particolare https://gist.github.com/gregseth/5582254 (by sonyarianto  on 8 Nov)
     * Questa espressione regolare accetta anche indirizzi email con utf-8
     * */
    function validateMail(mail) {
        return mail.toLowerCase().match(
            /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g
        );
    }


    if (!validateMail(email)) {
        $("#ErrorLoginDivContent").html("Indirizzo email non valido!");
        $("#ErrorLoginDiv").fadeIn();
        return;
    }

    var sendData = JSON.stringify({ "api": "log_in", "payload": { "email": email, "password": password } });
    $.ajax("./api/index.php", {
        data: sendData,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function(data) {
            if (data["Ok"] !== undefined) {
                window.location.href = "./user.shtml";
            } else {
                $("#ErrorLoginDivContent").html(data["Error"]);
                $("#ErrorLoginDiv").fadeIn();
            }
        }
    });
}

$(function() {
    $("#loginButton").click(login);
})