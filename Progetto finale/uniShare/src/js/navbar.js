function logout() {
    ajaxCall("log_out", {}, function() {
        window.location.href = "./";
    });
}
/*
 * questa funzione verifica il login e modifica l'aspetto della pagina di conseguenza quando 
la pagina è caricata in tutto
 * */
$(function() {
    $("#ButtonEsciNavbar").click(logout);
    ajaxCall("log_in_check", {}, function(data) {
        if (data["Status"] === "logged") {
            $(".NavBarNotLoggedOnly").remove();
        } else {
            $(".NavBarLoggedOnly").remove();
        }
    });
});