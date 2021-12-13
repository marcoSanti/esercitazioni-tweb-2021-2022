
/*
* questa funzione verifica il login e modifica l'aspetto della pagina di conseguenza
* */
function checkLogin(){
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "log_in_check", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if( data["Status"] === "logged"){
                $(".NavBarNotLoggedOnly").remove();
            }else{
                $(".NavBarLoggedOnly").remove();
            }
        }
    });

}

function logout(){
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "log_out", "payload" : [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            window.location.href = "./";
        }
    });
}

$(function (){
    $("#ButtonEsciNavbar").click(logout);
    checkLogin();
});


