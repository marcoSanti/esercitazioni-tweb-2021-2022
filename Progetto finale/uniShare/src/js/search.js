var queryResult = {}; //variabile globale che contiene i risultati delle query sui documenti

/**
 * funzione che preso l'input, va a fare una richiesta al server 
 * e poi aggiunge alla pagina le risposte con la funzione appendElementQuerySearch
 */
function search() {
    var queryParam = $("#QueryField").val();
    $("#SearchPageCardBox").empty();

    if (queryParam == "") {
        showAlert("info", "", "Per fvore inserisci una chiave di ricerca!");
        return;
    }

    ajaxCall("get_notes", { "query": queryParam }, function(data) {
        queryResult = data;
        if (Object.keys(data).length === 0) {
            showAlert("info", "Attenzione", "Non è stato trovato alcun risultato per la ricerca effettuata");
            return false;
        }
        $.each(data, function(index, item) {
            appendElementQuerySearch(item);
        });
    });
}

//funzione per aggiungere un elemento nella lista degli oggetti in output della quety
function appendElementQuerySearch(item) {
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
        btnAcquistaCode = "<button class=\"btn btn-primary\" id='AcquistaBtn" + item["codice"] + "'><i class=\"fas fa-shopping-cart\"></i> Acquista</button>\n";
    } else {
        btnAcquistaCode = "<p>Appunto acquistato. Naviga alla tua <a href='./user'>userpage</a> per poter visualizzare l'appunto</p>";
    }

    $("#SearchPageCardBox").append(
        "<div class='card'>\n" +
        "   <img src='src/media/paperNotes.svg' class='card-img-top' alt='noteImage'>\n" +
        "   <div class='card-body'>\n" +
        "       <div class='col card-review-stars'>\n" +
        reviewStarOutput + "\n" +
        "       </div>\n" +
        "       <h3>" + item["titolo"] + "</h3>\n" +
        "       <ul>\n" +
        "           <li><strong>Docente</strong> " + item["docente"] + "</li>\n" +
        "           <li><strong>Prezzo</strong> " + item["prezzo"] + "€</li>\n" +
        "           <li><strong>Data di upload</strong> " + item["uploadDate"] + "</li>\n" +
        "           <li><strong>Tipo di appunti</strong> " + tipoAppunti + "</li>\n" +
        "       </ul>\n" +
        "   </div>\n" +
        "   <div class='card-footer'>" +
        btnAcquistaCode +
        "    </div>" +
        "</div>\n");

    if (!item["bought"]) { //se oggetto non è acquistato
        $("#AcquistaBtn" + item["codice"]).click(function() {
            buyItem(this);
        });
    } else {
        $("#AcquistatoBtn" + item["codice"]).click(function() {
            window.location.href = "user.shtml"
        })
    }
}

/**
 * Questa funzione serve a simulare un acquisto di un oggetto 
 * e ad aggiungerlo a database. una volta acquistato,
 * viene modificato il comportamento del pulsante in modo che rimandi alla pagina utente
 * invece che a acquistare nuovamente l'oggetto
 * 
 * @param {*} item oggetto da acquistare 
 */
function buyItem(item) {
    var buyItemCode = $(item).attr("id").substring("AcquistaBtn".length);

    ajaxCall("add_bought_item", { "productId": buyItemCode }, function(data) {
        if (data["Ok"] !== undefined) {
            $(item).replaceWith(
                "<p>Appunto acquistato con successo. Naviga alla tua <a href='./user'>userpage</a> per poter visualizzare l'appunto</p>"
            );
        } else {
            $(item).removeClass("btn-info").addClass("btn-danger").html("Errore: impossibile acquistare");
            $(item).attr("id", "AcquistatoBtn" + buyItemCode).click(function() {
                //no action on error
            });
        }
    });
}

/**
 * Questa funzione va a caricare i valori disponibili come filtri
 */
function loadFiltersOptions() {
    ajaxCall("get_university_list", {}, function(data) {
        $(data).each(function(index, item) {
            $("#filterByUniversity").append("<option value='" + item["item"] + "'>" + item["item"] + "</option>");
        })
    });

    ajaxCall("get_teaching_list", {}, function(data) {
        $(data).each(function(index, item) {
            $("#filterByTeaching").append("<option value='" + item["item"] + "'>" + item["item"] + "</option>");
        })
    });

    ajaxCall("get_teachers", {}, function(data) {
        $(data).each(function(index, item) {
            $("#filterByTeacher").append("<option value='" + item["item"] + "'>" + item["item"] + "</option>");
        })
    });
}

/**
 * Questa funzione, va a filtrare l'input presente nella variabiel globale queryResult
 * e va poi a mostrare solamente gli oggetti che rispettano la query. nb: se un filtro vale -1, allora 
 * non faccio filtro su quella opzione
 */
function filterSearch() {

    if (Object.keys(queryResult).length === 0) {
        showAlert("warning", "Attenzione", "Non vi sono dati di partenza su cui applicare il filtro!");
        return false;
    }

    var prof = $("#filterByTeacher").val();
    var school = $("#filterByUniversity").val();
    var course = $("#filterByTeaching").val();
    $("#SearchPageCardBox").empty();
    $(queryResult).each(function(index, item) {


        if (
            (prof == "-1" || item["docente"] == prof) &&
            (course == "-1" || item["corso"] == course) &&
            (school == "-1" || item["scuola"] == school)
        ) appendElementQuerySearch(item);

    })

}

/**
 * Questa funzione va a effettuare un controllo su login e succcessivamente va a agganciare
 * gli handler dei pulsanti. infine binda il tasto invio alla funzione search().
 * inoltre se è settato il parametro q nell'url,+avvia automaticamente la ricerca (in quanto arrivo dalla homepage)
 */
$(function() {
    //se utente non è loggato faccio un redirect a login
    userLoginCheck();
    $("#QueryFieldSubmitButton").click(search);
    $("#FilterSearchButton").click(filterSearch);
    //verifico che non sia settato un get:
    let urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("q")) {
        $("#QueryField").val(urlParams.get("q"));
        search();
    }
    loadFiltersOptions();


}).keypress(function(e) {
    var key = e.which;
    if (key == 13) // pulsante invio
    {
        search();
    }
});