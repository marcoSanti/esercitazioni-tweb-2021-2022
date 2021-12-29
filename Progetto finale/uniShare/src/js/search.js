function search() {
    var queryParam = $("#QueryField").val();
    $("#SearchPageCardBox").empty();
    $.ajax("./api/index.php", {
        data: JSON.stringify({ "api": "get_notes", "payload": { "query": queryParam } }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function(data) {
            $.each(data, function(index, item) {

                if (item["tipoAppunti"] === "1") tipoAppunti = "Temi di esame";
                else if (item["tipoAppunti"] === "2") tipoAppunti = "Appunti lezioni";
                else tipoAppunti = "Esercitazioni";

                var reviewStarOutput = "";
                var btnAcquistaCode = "";
                for (let i = 0; i < 5; i++) {
                    if (i < item["rating"]) reviewStarOutput += "<i class=\"fas fa-star\"></i>\n";
                    else reviewStarOutput += "<i class=\"far fa-star\"></i>\n";
                }

                if (!item["bought"]) {
                    btnAcquistaCode = "<button class=\"btn btn-primary btn-buy-appunto\" id='AcquistaBtn" + item["codice"] + "'><i class=\"fas fa-shopping-cart\"></i> Acquista</button>\n";
                } else {
                    btnAcquistaCode = "<button class=\"btn btn-success btn-buy-appunto\" id='AcquistatoBtn" + item["codice"] + "'>Acquistato</button>\n";
                }

                $("#SearchPageCardBox").append(
                    " <div class=\"card cardAppuntoVendita\" id='Appunto' " + item["codice"] + ">\n" +
                    "                    <div class=\"card-header\">\n" +
                    "                        <div class=\"container\">\n" +
                    "                            <div class=\"row\">\n" +
                    "                                <div class=\"col-10\">\n" +
                    "                                    <strong>" + item["titolo"] + "</strong>" +
                    "                                </div>\n" +
                    "                                <div class=\"col\">\n" +
                    reviewStarOutput +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>\n" +
                    "                    </div>\n" +
                    "                    <div class=\"card-body\">\n" +
                    "                        <div class=\"container\">\n" +
                    "                            <div class=\"row d-flex justify-content-start\">\n" +
                    "                                <div class=\"col-10\">\n" +
                    "                                    <ul>\n" +
                    "                                        <li><strong>Docente</strong> " + item["docente"] + "</li>\n" +
                    "                                        <li><strong>Prezzo</strong> " + item["prezzo"] + "</li>\n" +
                    "                                        <li><strong>Data di upload</strong> " + item["uploadDate"] + "</li>\n" +
                    "                                        <li><strong>Tipo di appunti</strong> " + tipoAppunti + "</li>\n" +
                    "                                    </ul>\n" +
                    "                                </div>\n" +
                    "                                <div class=\"col\">\n" +
                    btnAcquistaCode +
                    "                                </div>\n" +
                    "                            </div>\n" +
                    "                        </div>"
                );

                if (!item["bought"]) { //se oggetto non è acquistato
                    $("#AcquistaBtn" + item["codice"]).click(function() {
                        buyItem(this);
                    });
                } else {
                    $("#AcquistatoBtn" + item["codice"]).click(function() {
                        window.location.href = "user.shtml"
                    })
                }

            });
        }
    });
}


function buyItem(item) {
    var buyItemCode = $(item).attr("id").substring("AcquistaBtn".length);
    console.log("pippo");
    $.ajax("./api/index.php", {
        data: JSON.stringify({ "api": "add_bought_item", "payload": { "productId": buyItemCode } }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data["Ok"] !== undefined) {
                $(item).removeClass("btn-info").addClass("btn-success").html("Acquistato");
                $(item).attr("id", "AcquistatoBtn" + buyItemCode).click(function() {
                    window.location.href = "user.shtml"
                });
            } else {
                $(item).removeClass("btn-info").addClass("btn-danger").html("Errore: impossibile acquistare");
                $(item).attr("id", "AcquistatoBtn" + buyItemCode).click(function() {
                    //no action on error
                });
            }
        }
    });
}


$(function() {
    //se utente non è loggato faccio un redirect a login
    $.ajax("./api/index.php", {
        data: JSON.stringify({ "api": "log_in_check", "payload": [] }),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function(data) {
            if (data["Status"] !== "logged") {
                window.location.href = "./login.shtml";
            } else {
                $("#QueryFieldSubmitButton").click(search);
                //verifico che non sia settato un get:
                let urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has("q")) {
                    $("#QueryField").val(urlParams.get("q"));
                    search();
                }
            }
        }
    });

})