/**Variabili globali per quando trascino e sposto il widget */
var oldX = null;
var oldY = null;
var moving = null;
var maxZ = 1000;
var lastPosition;

//variabile di stato per sapere se sto visualizzando il menu di personalizzazione dei widget
var menuShow = false;

/**
 * Questa funzione mostra e nasconde il menu laterale per la 
 * personalizzazione della dashboard della pagina utente
 */
function toggleEditPageMenu() {
    var button = $("#ToggleEditUserPage");
    if (!menuShow) {
        $("#SideMenuEditPage").fadeIn(100);
        button.html('Concludi personalizzazione');
    } else {
        $("#SideMenuEditPage").fadeOut(100);
        button.html('Personalizza aspetto');
    }
    menuShow = !menuShow;
}

/*
Questa funzione viene richiamata nel momento in cui vado a selezionare un nuovo widget
da aggiungere alla pagina 
*/
function widgetMouseButtonDown(event) {
    $(this).css({ "z-index": ++maxZ, "position": "absolute" }); // move clicked square to top
    moving = this;
    oldX = event.pageX; // remember this square for
    oldY = event.pageY;
}

/**
 * Questa funzione viene richiamata nel momento in cui rilascio il 
 * trascinamento del mouse, quando vado ad aggiungere un nuovo widget alla dashboard
 * come prima cosa, nasconde tutti gli overlay delle posizioni dei widget. dopo di che 
 * richiama la funzione di aggiunta del widget, infine va a preparare i dati per la chiamata al server
 * dove viene aggiornata la composizione della dashboard salvata a database con ajaxCall() 
 * @param {*} event l'oggetto soggetto dell'evento
 */
function widgetMouseButtonUp(event) {
    $("#" + event.target.id).css({ "position": "", "z-index": "", "top": "", "left": "" });

    let elementToAdd = event.target.id;
    let replacementContainer = $("#" + lastPosition.attr('id') + " .ContentsContainerGrid");

    addWidgetToPage(replacementContainer, elementToAdd, false);

    $(".UserPageOverlay").fadeOut(); //nascondo tutti gli overlay

    moving = null;

    var ajaxUpdateObject;
    var ajaxWidgetUpdate;
    switch (lastPosition.attr('id')) {
        case "ContainerGrid1-1":
            ajaxUpdateObject = 1;
            break;
        case "ContainerGrid1-2":
            ajaxUpdateObject = 2;
            break;
        case "ContainerGrid2-1":
            ajaxUpdateObject = 3;
            break;
        case "ContainerGrid2-2":
            ajaxUpdateObject = 4;
            break;
        default:
            return;
    }

    switch (elementToAdd) {
        case "AddWidgetProfileInfo":
            ajaxWidgetUpdate = 0;
            break;
        case "AddWidgetEarnings":
            ajaxWidgetUpdate = 1;
            break;
        case "AddWidgetExpenses":
            ajaxWidgetUpdate = 2;
            break;
        case "AddWidgetPurchase":
            ajaxWidgetUpdate = 3;
            break;
        case "AdminAddUserList":
            ajaxWidgetUpdate = 4;
            break;
        case "AdminAddCashFlow":
            ajaxWidgetUpdate = 5;
            break;
        case "AdminAddDocumentList":
            ajaxWidgetUpdate = 6;
            break;
        case "AdminAddAdminList":
            ajaxWidgetUpdate = 7;
            break;
        default:
            return;
    }

    ajaxCall("user_widget_pos_set", { "position": ajaxUpdateObject, "widget": ajaxWidgetUpdate }, function() { showAlert("success", "", "Widget salvato!") });
}

/**
 * Questa funzione va ad aggiungere un widget alla pagina.
 * Questo avviene andando a prendere il template del widget, il quale viene poi clonato (con la funzione .clone() di jquery).
 * Viene rimosso un eventuale widget dello stesso tipo già presente e infine viene aggiunto il widget nel target div
 * andando a richiamare la funzione che inizializza le informazioni del widget.
 * @param {*} replacementContainer il container target della sostituzione
 * @param {*} widgetToAdd  il widget che deve essere aggiunto
 */
function addWidgetToPage(replacementContainer, widgetToAdd) {
    var replacementWidget = null;

    if (widgetToAdd === "AddWidgetProfileInfo") {

        $("#WidgetAccountInfo").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateAccountWidget");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAccountInfo'));
        widgetLoadUserInfo();

    } else if (widgetToAdd === "AddWidgetEarnings") {

        $("#WidgetEarnings").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetEarnings");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetEarnings'));
        updateEarningsGraph();

    } else if (widgetToAdd === "AddWidgetExpenses") {

        $("#WidgetExpenses").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetExpenses");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetExpenses'));
        updateExpensesGraph();


    } else if (widgetToAdd === "AddWidgetPurchase") {

        $("#WidgetPurchase").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetPurchase");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetPurchase'));
        widgetLoadBoughtNotes();

    } else if (widgetToAdd === "AdminAddUserList") {

        $("#WidgetAdminUserList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminUsers");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminUserList'));
        widgetLoadSiteUsersAdmins(0);

    } else if (widgetToAdd === "AdminAddCashFlow") {

        $("#WidgetAdminCashFlow").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminIncomeExpenses");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminCashFlow'));
        widgetLoadCashFlow();

    } else if (widgetToAdd === "AdminAddDocumentList") {

        $("#WidgetAdminDocumentList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminDocuments");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminDocumentList'));
        widgetLoadNotesOnSale();

    } else if (widgetToAdd === "AdminAddAdminList") {
        $("#WidgetAdminList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminAdmins");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminList'));
        widgetLoadSiteUsersAdmins(1);
    }
}


/**
 * Questa funzione viene richiamata nel momento in cui sto trascinando un widget da aggiungere alla pagina. 
 * Se la posizione dell'oggetto è diversa, calcola la nuova posizione dell'oggetto, 
 * sposta il widget che si sta spostando, e infine va a calcolare se deve essere mostrato un overlay (nel caso il widget
 * trascinato si trovi al di sopra di una posizione valida, calcolata con gli attributi .left e .right di ognino 
 * dei 4 div presenti) andando anche a nascondere quello precedente.
 * 
 * Sfortunatamente, non è possibile semplificare questo codice, senza entrare in uno scomodo effetto strobo degli overlay.
 * Essi infatti, se si prova a semplificare il codice, iniziano a lampeggiare, come passo sopra con il mouse.
 * 
 * @param {*} event 
 */
function widgetAddMove(event) {

    if (this === moving && oldX !== null && oldY !== null) {

        var positionX = parseInt($(this).css("left")) + (event.pageX - oldX);
        var positionY = parseInt($(this).css("top")) + (event.pageY - oldY);

        $(this).css({ "left": positionX + "px" });
        $(this).css({ "top": positionY + "px" });

        oldX = event.pageX; // update old x/y to current position
        oldY = event.pageY;

        //check that i am not hovering onto one of the possible target of the grid
        var GridCell1 = $("#ContainerGrid1-1");
        var GridCell2 = $("#ContainerGrid1-2");
        var GridCell3 = $("#ContainerGrid2-1");
        var GridCell4 = $("#ContainerGrid2-2");

        if (
            positionX >= GridCell1.position().left &&
            positionX <= (GridCell1.position().left + GridCell1.width()) &&
            positionY >= GridCell1.position().top &&
            positionY <= (GridCell1.position().top + GridCell1.height())
        ) {
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeIn();
            lastPosition = GridCell1;
        } else if (
            positionX >= GridCell2.position().left &&
            positionX <= (GridCell2.position().left + GridCell1.width()) &&
            positionY >= GridCell2.position().top &&
            positionY <= (GridCell2.position().top + GridCell1.height())
        ) {
            $("#overlay1-2").fadeIn();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition = GridCell2;
        } else if (
            positionX >= GridCell3.position().left &&
            positionX <= (GridCell3.position().left + GridCell1.width()) &&
            positionY >= GridCell3.position().top &&
            positionY <= (GridCell3.position().top + GridCell1.height())
        ) {
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeIn();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition = GridCell3;
        } else if (
            positionX >= GridCell4.position().left &&
            positionX <= (GridCell4.position().left + GridCell1.width()) &&
            positionY >= GridCell4.position().top &&
            positionY <= (GridCell4.position().top + GridCell1.height())
        ) {
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeIn();
            $("#overlay1-1").fadeOut();
            lastPosition = GridCell4;
        } else {
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition = null;
        }

    }
}

/*WIDGETS */

/**
 * Questa funzione va a inizializzare i dati del grafico del widget degli acquisti.
 * Il grafico è gestito da chart.js
 * 
 */
function updateExpensesGraph() {
    ajaxCall("chart_buy", {}, function(serverData) {
        var ExpensesChartCanvas = $("#Expenses_canvas");
        if (ExpensesChartCanvas) {
            const data = {
                labels: serverData["labels"],
                datasets: [{
                    label: 'Guadagni mensili',
                    data: serverData["values"],
                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),
                }]
            };
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            // position: 'right',
                            display: false
                        },
                        title: {
                            display: false,
                        },
                        responsive: true,
                    }
                },
            };
            var ExpensesChart = new Chart(ExpensesChartCanvas, config);
            $(serverData["labels"]).each(function(index, item) {
                $("#WidgetExpenses ul").append(" <li class='list-group-item'>" + item + "</li>");
            })
        }
    })
}

/**
 * Questa funzione va a inizializzare i dati del grafico del widget degli incassi delle vendite di appunti.
 * Il grafico è gestito da chart.js
 * 
 */
function updateEarningsGraph() {
    ajaxCall("chart_income", {}, function(serverData) {
        var EarningsChartCanvas = $("#Earnings_canvas");
        if (EarningsChartCanvas) {
            const data = {
                labels: serverData["labels"],
                datasets: [{
                    label: 'Guadagni mensili',
                    data: serverData["values"],
                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),
                }]
            };
            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            // position: 'right',
                            display: false
                        },
                        title: {
                            display: false,
                        },
                        responsive: true,
                    }
                },
            };
            var EarningChartCanvas = new Chart(EarningsChartCanvas, config);
        }

        $(serverData["labels"]).each(function(index, item) {
            $("#WidgetEarnings ul").append(" <li class='list-group-item'>" + item + "</li>");
        })
    });
}

/**
 * Questa funzione va a impostare sia i widget (visibili solamente da admin) che elenca gli utenti
 * sia il widget che elenca gli amministratori del sito.
 * 
 * @param {*} type il tipo: se voglio avere gli utenti del sito o gli amministratori del sito 
 */
function widgetLoadSiteUsersAdmins(type) {
    ajaxCall("admin_get_users", { "type": type }, function(data) {
        var target = "";
        if (type === 1) target = "WidgetAdminList";
        else target = "WidgetAdminUserList";

        $.each(data, function(index, item) {
            $("#" + target + " ul").append(" <li class='list-group-item'>" + item["Name"] + " " + item["Surname"] + "</li>");
        });
    });
}

/**
 * Questa funzione va a impostare il widget che mostra le informazioni dell'utente corrente
 */
function widgetLoadUserInfo() {
    ajaxCall("user_info_get", {}, function(data) {
        $("#WidgetAccountInfo .col").eq(1).append(
            "<div class='row'>" + data["Name"] + "</div>" +
            "<div class='row'>" + data["Surname"] + "</div>" +
            "<div class='row'>" + data["email"] + "</div>"
        );
    });
}

/**
 * Questa funzione inizializza il widget che va a mostrare il numero di note che sono 
 * state acquistate
 */
function widgetLoadBoughtNotes() {
    ajaxCall("get_bought_notes", {}, function(data) {
        $("#WidgetPurchase div").append("<h5>Hai acquistato <strong>" + data.length + "</strong> appunti.</h5");
    });
}

/**
 * Questa funzione inizializza il widget che va a mostrare il numero di note che sono in vendita
 */
function widgetLoadNotesOnSale() {
    ajaxCall("get_sale", {}, function(data) {
        $("#WidgetAdminDocumentList div").append("<h5>Sono presenti <strong>" + data.length + "</strong> appunti sul sito.</h5");
    });
}

/**
 * Questa funzione inizializza il widget, visibile solo agli admin, che mostra quanti sono i soldi guadagnati dalle vendite
 * e quanti sono i soldi che sono stati pagati ai proprietari del sito
 */

function widgetLoadCashFlow() {
    ajaxCall("cashflow", {}, function(data) {
        $("#WidgetAdminCashFlow div").append("<i class='fas fa-arrow-up'></i> " + data["in"] + "€  <i class='fas fa-arrow-down'></i> " + data["out"] + "€");
    });
}
/**FINE WIDGETS */


/**
 * Questa funzione serve per la navigazione tra i tab della pagina utente.
 * va a pulire l'area vista dall'utente e a rimuovere il tag attivo alla etichetta
 * della tab.
 */
function ClearUserPageViewBlock() {
    $(".view-block").fadeOut(10);
    $(".nav-link").removeClass("active");
}

/**
 * Questa funzione verifica il tipo di utente, e se esso non è amministratore,+rimuove tutti gli elementi
 * della pagina user marchiati con la classe adminOnly
 */
function checkUserType() {
    ajaxCall("user_type_get", {}, function(data) {
        if (data["UserType"] === "USER") {
            $(".adminOnly").remove();
        }
    });
}

/**
 * Questa funione carica le informazioni dell'utente da mostrare nella 
 * tab delle informaizoni dell'utente
 */
function LoadUserPageDetails() {
    ajaxCall("user_info_get", {}, function(data) {
        $("#UserDataName").val(data["Name"]);
        $("#UserDataSurname").val(data["Surname"]);
        $("#UserDataMail").val(data["email"]);
    });

    $("#UserDataEditPassword").click(function() {
        $("#passwordChangeDiv").toggle();
        $("#oldPassword").val("");
        $("#newPassword1").val("");
        $("#newPassword2").val("");

        $("#btnConfirmChangePassword").click(changePassword);
    })
}

/**
 * Questa funzione va a cambiare la password, confrontando prima che l'utente
 * abbia inserito correttamente la password entrambe le volte
 * e poi facendo la chiamata alle api del server con ajaxCall
 */
function changePassword() {
    var oldPsw = $("#oldPassword").val();
    var newPsw = $("#newPassword1").val();
    var newPsw1 = $("#newPassword2").val();
    if (newPsw1 === newPsw && oldPsw !== "" && newPsw !== "") {
        ajaxCall("update_psw", { "oldPassword": oldPsw, "newPassword": newPsw }, function(data) {
            if (data["Ok"] !== undefined) {
                $("#passwordChangeDiv").fadeOut();
                showAlert("success", "Successo!", "password modificata con successo");
            }
        }, function(data) {
            var errorMessage = JSON.parse(data["responseText"]);
            showAlert("danger", "Errore", errorMessage["Error"]);
        });
    } else {
        showAlert("warning", "Attenzione", "Le password nuove non coincidono");
    }
}

/**
 * Questa funzione va a aggiungere i widget alla dashboard nel momento in cui accedo alla pagina, 
 * in base a cosa ho salvao a server. Va a selezionare prima quale sia il quadrante target e 
 * successivamente a selezionare quale widget deve aggiungere nel target
 * 
 */
function LoadDashboardWidgets() {
    ajaxCall("user_dashboard_get", {}, function(data) {
        var widgetToAdd;
        var targetDiv;
        $.each(data, function(index, value) {

            switch (index) {
                case "obj1":
                    targetDiv = $("#ContainerGrid1-1 .ContentsContainerGrid");
                    break;
                case "obj2":
                    targetDiv = $("#ContainerGrid1-2 .ContentsContainerGrid");
                    break;
                case "obj3":
                    targetDiv = $("#ContainerGrid2-1 .ContentsContainerGrid");
                    break;
                case "obj4":
                    targetDiv = $("#ContainerGrid2-2 .ContentsContainerGrid");
                    break;
                default:
                    return;
            }

            switch (parseInt(value)) {
                case 0:
                    widgetToAdd = "AddWidgetProfileInfo";
                    break;
                case 1:
                    widgetToAdd = "AddWidgetEarnings";
                    break;
                case 2:
                    widgetToAdd = "AddWidgetExpenses";
                    break;
                case 3:
                    widgetToAdd = "AddWidgetPurchase";
                    break;
                case 4:
                    widgetToAdd = "AdminAddUserList";
                    break;
                case 5:
                    widgetToAdd = "AdminAddCashFlow";
                    break;
                case 6:
                    widgetToAdd = "AdminAddDocumentList";
                    break;
                case 7:
                    widgetToAdd = "AdminAddAdminList";
                    break;
                default:
                    return;
            }

            addWidgetToPage(targetDiv, widgetToAdd);
        });
    });

}


/**
 * 
 * Questa funzione si occupa di inviare al server le modifiche al nome e al cognome dell'utente
 */
function editUserInformations() {
    var name = $("#UserDataName").val();
    var surname = $("#UserDataSurname").val();

    if (name === "" || surname === "") {
        showAlert("danger", "Errore", "Nome e cognome devono essere presenti!");
        return;
    }

    ajaxCall("update_user_info", { "name": name, "surname": surname }, function(data) {
        if (data["Ok"] !== undefined) {
            showAlert("success", "", "Dati aggiornati con successo");
        } else {
            showAlert("danger", "Error", "Errore nell'aggiornamento dei dati");
            console.log(data);
        }
    });
}

/**
 * Questa funzione aggiunge le note acquistate alla pagina mostrata all'utente, andando a preparare le
 * varie parti della linea mostrata
 * 
 */

function getUserBoughtNote() {
    ajaxCall("get_bought_notes", {}, function(data) {
        $.each(data, function(index, item) {

            if (item["tipoAppunti"] === "1") tipoAppunti = "Temi di esame";
            else if (item["tipoAppunti"] === "2") tipoAppunti = "Appunti lezioni";
            else tipoAppunti = "Esercitazioni";

            var review = "";

            if (item["reviewed"] === false) {
                review = "                                  <button class='btn btn-primary' id='feedbackBtn" + item["codice"] + "'>Feedback</button>";
            }
            console.log(item);
            $("#NotesBoughtBox").append(
                " <div class=\"card cardAppuntoVendita\" id='Appunto' " + item["codice"] + ">\n" +
                "                    <div class=\"card-header\">\n" +
                "                        <div class=\"container\">\n" +
                "                            <div class=\"row\">\n" +
                "                                <div class=\"col-10\">\n" +
                "                                    <strong>" + item["titolo"] + "</strong>" +
                "                                </div>\n" +
                "                                <div class=\"col\">" +
                review +
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
                "                                   <button id='" + item["Path"] + "' class=\"btn btn-warning btn-download-note\" id='AcquistaBtn" + item["codice"] + "'><i class=\"fas fa-download\"></i>Scarica</button>\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>"
            );

            $("#feedbackBtn" + item["codice"]).click(function() {
                $("#feedbackBtn" + item["codice"]).replaceWith(
                    "<div class='input-group' id='feedbackInput" + item["codice"] + "'> " +
                    "<select class='form-select' id='reviewValue" + item["codice"] + "'>" +
                    "<option value='1'>1/5</option>" +
                    "<option value='2'>2/5</option>" +
                    "<option value='3'>3/5</option>" +
                    "<option value='4'>4/5</option>" +
                    "<option value='5' selected>5/5</option>" +
                    "</select> <button id='btnAddReview" + item["codice"] + "' class='btn btn-success'>Conferma</button></div>");

                $("#btnAddReview" + item["codice"]).click(function() {
                    ajaxCall("add_review", { "note": item["codice"], "value": $("#reviewValue" + item["codice"]).val() }, function(data) {
                        if (data["Ok"] !== undefined) {
                            showAlert("success", "", "Recensione aggiunta con successo");
                            $("#feedbackInput" + item["codice"]).fadeOut();
                        }
                    });
                });
            });

            $("#" + item["Path"]).click(function() {
                window.location.href = "./api/obtainDocument.php?doc=" + item["Path"];
            });

        });
    });
}


/**
 * Questa funzione va a mostrare gli appunti in vendita
 */
function showNoteSales() {
    ajaxCall("get_sale", {}, function(data) {
        $.each(data, function(index, item) {

            if (item["tipoAppunti"] === "1") tipoAppunti = "Temi di esame";
            else if (item["tipoAppunti"] === "2") tipoAppunti = "Appunti lezioni";
            else tipoAppunti = "Esercitazioni";


            $("#UserSellingsViewBlock").append(
                " <div class=\"card cardAppuntoVendita\" id='Appunto' " + item["codice"] + ">\n" +
                "                    <div class=\"card-header\">\n" +
                "                        <div class=\"container\">\n" +
                "                            <div class=\"row\">\n" +
                "                                <div class=\"col-10\">\n" +
                "                                    <strong>" + item["titolo"] + "</strong>" +
                "                                </div>\n" +
                "                                <div class=\"col\">" +
                "                                  <strong class='bold'>Guadagno: " + item["earnings"] + "€</strong>" +
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
                "                                        <li><strong>Prezzo</strong> " + item["price"] + "</li>\n" +
                "                                        <li><strong>Data di upload</strong> " + item["uploadDate"] + "</li>\n" +
                "                                        <li><strong>Tipo di appunti</strong> " + tipoAppunti + "</li>\n" +
                "                                    </ul>\n" +
                "                                </div>\n" +
                "                                <div class=\"col\">\n" +
                "                                   <button class=\"btn btn-download-note\" id='pullNota" + item["codice"] + "'></button>" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                        </div>"
            );


            if (item["visible"] === "0")
                $("#pullNota" + item["codice"]).addClass("btn-primary").html("Metti in vendita").click(function() { pullNoteInner(item["codice"], 0, "Rimuovi dalla vendita", "Metti in vendita", "btn-danger", "btn-primary") });
            else
                $("#pullNota" + item["codice"]).addClass("btn-danger").html("Rimuovi dalla vendita").click(function() { pullNoteInner(item["codice"], 1, "Metti in vendita", "Rimuovi dalla vendita", "btn-primary", "btn-danger") });

        });
    });
}

/**
 * Questa funzione va a togliere o a rimettere in vendita un appunto 
 * 
 * @param {*} id id dell'oggetto da togliere o da rimetterer in vendita
 * @param {*} pull se la nota è da rimuovere (true) o da rimettere in vendita (false)
 * @param {*} oldLabel etichetta precedente del pulsante
 * @param {*} newLabel  nuova etichetta del pulsante
 * @param {*} removeClass vecchio tipo del pulsante
 * @param {*} addClass nuovo tipo del pulsante
 */
function pullNoteInner(id, pull, oldLabel, newLabel, removeClass, addClass) {
    ajaxCall("pull_note", { "codice": id, "pull": pull }, function() {
        $("#pullNota" + id).removeClass(addClass).addClass(removeClass).html(oldLabel).off("click").click(function() {
            pullNoteInner(id, +!pull, newLabel, oldLabel, addClass, removeClass) // l'operatore +!1 converte false (dato da !1 in intero...)
        });
    });

}

/**
 * Questa funzione va a elencare o gli utenti del sito o gli amministratori del sito e li
 * va a mostrare nel giusto posto a seconda del tipo. per ogni utente va poi a aggiungere
 * i pulsanti (solo elmina in caso di admin) elimina e promuovi e a collegare i relativi
 * handler dei click
 * @param {*} type il tipo dell'utente: 0=ottiene gli user, 1=ottiene gli admin
 */
function getUsers(type) {

    if (type === 0) {
        target = "#TableAdminUserList";
    } else if (type === 1) {
        target = "#TableAdminAdminList";
    } else {
        return;
    }

    $(target).empty();

    ajaxCall("admin_get_users", { "type": type }, function(data) {

        $.each(data, function(index, item) {
            if (type === 0) {
                var buttons = "<td><button class = 'btn btn-primary' id = 'btnPromote" + index + "'> Promuovi admin </button>" +
                    "<button class = 'btn btn-danger' id = 'btnDelete" + index + "'> Elimina utente </button></td> ";
            } else {
                var buttons = "<td><button class = 'btn btn-danger' id = 'btnDelete" + index + "'> Elimina utente </button></td> ";

            }

            $(target).append("<tr id='UserRow" + index + "'><td> " + item["email"] + "</td><td> " + item["Name"] + "</td><td> " + item["Surname"] + "</td> " + buttons + "</tr>");

            $("#btnPromote" + index).click(function() {
                ajaxCall("promote_user", { "username": item["email"] }, function() {
                    showAlert("success", "Success", "Utente promosso a amministratore");
                    $("#UserRow" + index).fadeOut();
                })
            });
            $("#btnDelete" + index).click(function() {
                ajaxCall("drop_user", { "userId": item["email"] }, function() {
                    showAlert("success", "", "Utente eliminato");
                    $("#UserRow" + index).fadeOut();
                })
            });
        });
    });
}

/**
 * Questa funzione va a  elencare i documenti che sono stati acquistati aggiungendo il pulsante per poter scaricare
 * il documento.
 * 
 */
function adminListDocuments() {
    ajaxCall("admin_list_notes", {}, function(data) {
        $.each(data, function(index, item) {
            $("#TableAdminDocumentList").append(
                "<tr id = 'DocumentRow" + index + "'>" +
                "<td> " + item["idappunti"] + "</td>" +
                "<td> " + item["nome"] + "</td>" +
                "<td> " + item["user"] + "</td>" +
                "<td> " + item["price"] + "</td>" +
                "<td><div class='btn-group'>" +
                "<a href = './api/obtainDocument.php?doc=" + item["Path"] + "' class='btn btn-primary'>Scarica</a>" +
                "<button class='btn btn-danger' id='deleteDocumentButton" + index + "'>Elimina Documento</button>" +
                "</div></td>" +
                "</tr>"
            );
            $("#deleteDocumentButton" + index).click(function() {
                ajaxCall("drop_note", { "noteId": item["idappunti"] }, function() {
                    showAlert("success", "", "Documento eliminato con successo");
                    $("#DocumentRow" + index).fadeOut();
                })
            });

        });
    });
}

/**
 * Funzione eseguita quando la pagina è caricata completamente.
 * si compone principalmente di due parti: la prima va a impostare gli handler per gli eventi del mouse
 * nel menu di aggiuta dei widget della dashboard.
 * La seconda parte invece va a impostare i comportamenti del cambio di visualizzazione del tab
 */
$(function() {

    userLoginCheck();

    $("#ToggleEditUserPage").click(toggleEditPageMenu);

    $(".widget-add-button").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });

    $("#TabShowDashboard").click(function() {
        ClearUserPageViewBlock();
        $("#WidgetViewBlock").fadeIn(10);
        $("#TabShowDashboard").addClass("active");
    });

    $("#TabShowUserProfile").click(function() {
        ClearUserPageViewBlock();
        $("#passwordChangeDiv").hide();
        LoadUserPageDetails();
        $("#UserProfileViewBlock").fadeIn(10);
        $("#TabShowUserProfile").addClass("active");
    });

    $("#TabShowUserPurchase").click(function() {
        ClearUserPageViewBlock();
        $("#NotesBoughtBox").empty();
        getUserBoughtNote();
        $("#UserPurchaseViewBlock").fadeIn(10);
        $("#TabShowUserPurchase").addClass("active");
    });

    $("#TabShowUserEarnings").click(function() {
        ClearUserPageViewBlock();
        $("#UserSellingsViewBlock").empty();
        showNoteSales();
        $("#UserSellingsViewBlock").fadeIn(10);
        $("#TabShowUserEarnings").addClass("active");
    });

    $("#TabShowAdminUserList").click(function() {
        ClearUserPageViewBlock();
        getUsers(0);
        $("#AdminUserList").fadeIn(10);
        $("#TabShowAdminUserList").addClass("active");
    });

    $("#TabShowAdminDocumentList").click(function() {
        ClearUserPageViewBlock();
        $("#TableAdminDocumentList").empty();
        adminListDocuments();
        $("#AdminDocumentList").fadeIn(10);
        $("#TabShowAdminDocumentList").addClass("active");
    });

    $("#TabShowAdminAdmins").click(function() {
        ClearUserPageViewBlock();
        getUsers(1);
        $("#AdminAdminList").fadeIn(10);
        $("#TabShowAdminAdmins").addClass("active");
    });

    $("#UserDataEditValues").click(function() {
        editUserInformations();
    });

    //loading page contents
    checkUserType();
    LoadDashboardWidgets();
});