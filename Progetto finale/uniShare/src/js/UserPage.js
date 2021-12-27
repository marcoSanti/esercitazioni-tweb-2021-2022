var oldX = null;
var oldY = null;
var moving = null;
var maxZ = 1000;
var lastPosition;
var menuShow = false;

function toggleEditPageMenu() {
    var button = $("#ToggleEditUserPage");
    if (!menuShow) {
        $("#SideMenuEditPage").fadeIn(100);
        button.html('Conferma');
    } else {
        $("#SideMenuEditPage").fadeOut(100);
        button.html('Personalizza aspetto');
    }
    menuShow = !menuShow;
}

function widgetMouseButtonDown(event) {
    $(this).css({ "z-index": ++maxZ, "position": "absolute" }); // move clicked square to top
    moving = this;
    oldX = event.pageX; // remember this square for
    oldY = event.pageY;

}

/*
 * funzione wrapper del metodo ajax.
 * payload è un oggetto json
 * whendone deve accettare come risultato data che è l'output del server
 * */
function ajaxCall(api, payload, whenDone = function(data) {}, whenError = function(data) { console.log(data) }) {
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

function widgetMouseButtonUp(event) {
    $("#" + event.target.id).css({ "position": "", "z-index": "", "top": "", "left": "" });

    let elementToAdd = event.target.id;
    let replacementContainer = $("#" + lastPosition.attr('id') + " .ContentsContainerGrid");

    addWidgetToPage(replacementContainer, elementToAdd, false);

    $("#overlay1-2").fadeOut();
    $("#overlay2-1").fadeOut();
    $("#overlay2-2").fadeOut();
    $("#overlay1-1").fadeOut();
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
            console.log("UpdateWidgetServer1");
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
            console.log("UpdateWidgetServer2");
            return;
    }

    ajaxCall("user_widget_pos_set", { "position": ajaxUpdateObject, "widget": ajaxWidgetUpdate });
}

function addWidgetToPage(replacementContainer, widgetToAdd) {
    var replacementWidget = null;

    if (widgetToAdd === "AddWidgetProfileInfo") {

        $("#WidgetAccountInfo").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateAccountWidget");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAccountInfo'));


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

    } else if (widgetToAdd === "AdminAddUserList") {

        $("#WidgetAdminUserList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminUsers");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminUserList'));

    } else if (widgetToAdd === "AdminAddCashFlow") {

        $("#WidgetAdminCashFlow").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminIncomeExpenses");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminCashFlow'));

    } else if (widgetToAdd === "AdminAddDocumentList") {

        $("#WidgetAdminDocumentList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminDocuments");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminDocumentList'));

    } else if (widgetToAdd === "AdminAddAdminList") {
        $("#WidgetAdminList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminAdmins");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminList'));
    }
}

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


function updateExpensesGraph() {
    var ExpensesChartCanvas = $("#Expenses_canvas");
    if (ExpensesChartCanvas) {
        const data = {
            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],
            datasets: [{
                label: 'Guadagni mensili',
                data: [100, 200, 300, 400, 500],
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
    }
}

function updateEarningsGraph() {
    var EarningsChartCanvas = $("#Earnings_canvas");
    if (EarningsChartCanvas) {
        const data = {
            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],
            datasets: [{
                label: 'Guadagni mensili',
                data: [100, 200, 300, 400, 500],
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
}


function ClearUserPageViewBlock() {
    $("#UserProfileViewBlock").fadeOut(10);
    $("#UserPurchaseViewBlock").fadeOut(10);
    $("#UserSellingsViewBlock").fadeOut(10);
    $("#WidgetViewBlock").fadeOut(10);
    $("#AdminUserList").fadeOut(10);
    $("#AdminCashFlow").fadeOut(10);
    $("#AdminAdminList").fadeOut(10);
    $("#AdminDocumentList").fadeOut(10);

    $("#TabShowDashboard").removeClass("active");
    $("#TabShowUserPurchase").removeClass("active");
    $("#TabShowUserProfile").removeClass("active");
    $("#TabShowUserEarnings").removeClass("active");
    $("#TabShowAdminUserList").removeClass("active");
    $("#TabShowAdminAdmins").removeClass("active");
    $("#TabShowAdminCashflow").removeClass("active");
    $("#TabShowAdminDocumentList").removeClass("active");
}

function checkUserType() {
    ajaxCall("user_type_get", {}, function(data) {
        if (data["UserType"] === "USER") {
            $(".adminOnly").remove();
        }
    });
}


function LoadUserPageDetails() {
    ajaxCall("user_info_get", {}, function(data) {
        $("#UserDataName").val(data["Name"]);
        $("#UserDataSurname").val(data["Surname"]);
        $("#UserDataMail").val(data["email"]);
    });

    $("#UserDataEditPassword").click(function() {
        $("#passwordChangeDiv").fadeIn();
        $("#UserDataEditPassword").html("Conferma modifiche").click(function() {
            var oldPsw = $("#oldPassword").val();
            var newPsw = $("#newPassword1").val();
            var newPsw1 = $("#newPassword2").val();
            if (newPsw1 === newPsw && oldPsw !== "" && newPsw !== "") {
                ajaxCall("update_psw", { "oldPassword": oldPsw, "newPassword": newPsw }, function(data) {
                    if (data["Ok"] !== undefined) {
                        $("#passwordChangeDiv").replaceWith("<div class='alert alert-success alert-dismissible fade show' role='alert'>Password modificata con successo<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
                        $("#UserDataEditPassword").fadeOut();
                    }
                }, function(data) { alert(data["Error"]) });
            } else {
                alert("Le nuove password non coincidono oppure non hai inserito tutti i dati!")
            }
        });
    })
}

function LoadDashboardWidgetsDone(data) {
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
}

function editUserInformations() {
    var name = $("#UserDataName").val();
    var surname = $("#UserDataSurname").val();

    if (name === "" || surname === "") {
        return;
    }

    ajaxCall("update_user_info", { "name": name, "surname": surname }, function(data) {
        if (data["Ok"] !== undefined) {
            $("#UserDataUpdateSuccessDiv").fadeIn();
        } else {
            $("#UserDataUpdateErrorDiv").fadeIn();
        }
    });
}

function getUserBoughtNoteDone(data) {
    $.each(data, function(index, item) {

        if (item["tipoAppunti"] === "1") tipoAppunti = "Temi di esame";
        else if (item["tipoAppunti"] === "2") tipoAppunti = "Appunti lezioni";
        else tipoAppunti = "Esercitazioni";

        var btnAcquistaCode = "<button id='" + item["Path"] + "' class=\"btn btn-warning btn-buy-appunto\" id='AcquistaBtn" + item["codice"] + "'><i class=\"fas fa-download\"></i>Scarica</button>\n";


        $("#NotesBoughtBox").append(
            " <div class=\"card cardAppuntoVendita\" id='Appunto' " + item["codice"] + ">\n" +
            "                    <div class=\"card-header\">\n" +
            "                        <div class=\"container\">\n" +
            "                            <div class=\"row\">\n" +
            "                                <div class=\"col-10\">\n" +
            "                                    <strong>" + item["titolo"] + "</strong>" +
            "                                </div>\n" +
            "                                <div class=\"col\">" +
            "                                  <button class='btn btn-primary'>Feedback</button>" +
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

        $("#" + item["Path"]).click(function() {
            window.location.href = "./api/obtainDocument.php?doc=" + item["Path"];
        });

    });
}

function userLoginCheck() {
    //se utente non è loggato faccio un redirect a login
    ajaxCall("log_in_check", {}, function(data) {
        if (data["Status"] === undefined || data["Status"] !== "logged") {
            console.log(data);
            //window.location.href = "./login.php";
        }
    });
}

function showNoteSalesDone(data) {
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
            "                                        <li><strong>Prezzo</strong> " + item["prezzo"] + "</li>\n" +
            "                                        <li><strong>Data di upload</strong> " + item["uploadDate"] + "</li>\n" +
            "                                        <li><strong>Tipo di appunti</strong> " + tipoAppunti + "</li>\n" +
            "                                    </ul>\n" +
            "                                </div>\n" +
            "                                <div class=\"col\">\n" +
            "                                   <button class=\"btn btn-buy-appunto\" id='pullNota" + item["codice"] + "'></button>" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                        </div>"
        );


        if (item["visible"] === "0")
            $("#pullNota" + item["codice"]).addClass("btn-primary").html("Metti in vendita").click(function() { pullNoteInner(item["codice"], 0, "Rimuovi dalla vendita", "Metti in vendita", "btn-danger", "btn-primary") });
        else
            $("#pullNota" + item["codice"]).addClass("btn-danger").html("Rimuovi dalla vendita").click(function() { pullNoteInner(item["codice"], 1, "Metti in vendita", "Rimuovi dalla vendita", "btn-primary", "btn-danger") });

    });
}
//funzione per fare toggle sul pulsante per rimuovere le note in vendita
function pullNoteInner(id, pull, oldLabel, newLabel, removeClass, addClass) {
    ajaxCall("pull_note", { "codice": id, "pull": pull }, function() {
        $("#pullNota" + id).removeClass(addClass).addClass(removeClass).html(oldLabel).off("click").click(function() {
            pullNoteInner(id, +!pull, newLabel, oldLabel, addClass, removeClass) // l'operatore +!1 converte false (dato da !1 in intero...)
        });
    });

}

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
            var buttons = "<td><button class = 'btn btn-primary' id = 'btnPromote" + index + "'> Promuovi admin </button>" +
                "<button class = 'btn btn-danger' id = 'btnDelete" + index + "'> Elimina utente </button></td> ";

            $(target).append("<tr id='UserRow" + index + "'><td> " + item["email"] + "</td><td> " + item["Name"] + "</td><td> " + item["Surname"] + "</td> " + buttons + "</tr>");

            $("#btnPromote" + index).click(function() {
                ajaxCall("promote_user", { "username": item["email"] }, function() { $("#UserRow" + index).fadeOut(); })
            });
            $("#btnDelete" + index).click(function() {
                ajaxCall("drop_user", { "userId": item["email"] }, function() { $("#UserRow" + index).fadeOut(); })
            });
        });
    });
}

function adminListDocumentsDone(data) {
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
            ajaxCall("drop_note", { "noteId": item["idappunti"] }, function() { $("#DocumentRow" + index).fadeOut(); })
        });

    });
}

$(function() {

    userLoginCheck();

    $("#ToggleEditUserPage").click(toggleEditPageMenu);

    $("#AddWidgetProfileInfo").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetPurchase").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetEarnings").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetExpenses").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AdminAddAdminList").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AdminAddCashFlow").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AdminAddDocumentList").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AdminAddUserList").on({
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
        $("#UserProfileViewBlock").fadeIn(10);
        $("#TabShowUserProfile").addClass("active");
        LoadUserPageDetails();
    });

    $("#TabShowUserPurchase").click(function() {
        ClearUserPageViewBlock();
        $("#NotesBoughtBox").empty();
        ajaxCall("get_bought_notes", {}, getUserBoughtNoteDone);
        $("#UserPurchaseViewBlock").fadeIn(10);
        $("#TabShowUserPurchase").addClass("active");
    });

    $("#TabShowUserEarnings").click(function() {
        ClearUserPageViewBlock();
        $("#UserSellingsViewBlock").empty();
        ajaxCall("get_sale", {}, showNoteSalesDone);
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
        ajaxCall("admin_list_notes", {}, adminListDocumentsDone);

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
    ajaxCall("user_dashboard_get", {}, LoadDashboardWidgetsDone);
});