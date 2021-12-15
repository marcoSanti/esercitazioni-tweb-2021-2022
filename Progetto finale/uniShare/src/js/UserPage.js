var oldX = null;
var oldY = null;
var moving = null;
var maxZ = 1000;
var lastPosition;
var menuShow = false;

function toggleEditPageMenu(){
    var button = $("#ToggleEditUserPage");
    if(!menuShow){
        $("#SideMenuEditPage").fadeIn(100);
        button.html('Conferma');
    }else{
        $("#SideMenuEditPage").fadeOut(100);
        button.html('Personalizza aspetto');
    }
    menuShow = !menuShow;
}

function widgetMouseButtonDown(event) {
    $(this).css({"z-index" : ++maxZ, "position" : "absolute"}); // move clicked square to top
    moving = this;
    oldX = event.pageX;        // remember this square for
    oldY = event.pageY;

}

function widgetMouseButtonUp(event) {
    $("#"+event.target.id).css({"position" : "", "z-index":"", "top": "", "left":""});

    let elementToAdd = event.target.id;
    let replacementContainer = $("#" + lastPosition.attr('id')  + " .ContentsContainerGrid");

    addWidgetToPage(replacementContainer, elementToAdd, false);

    $("#overlay1-2").fadeOut();
    $("#overlay2-1").fadeOut();
    $("#overlay2-2").fadeOut();
    $("#overlay1-1").fadeOut();
    moving = null;

    var ajaxUpdateObject;
    var ajaxWidgetUpdate;
    switch(lastPosition.attr('id')){
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

    switch(elementToAdd){
        case "AddWidgetProfileInfo":
            ajaxWidgetUpdate=0;
            break;
        case "AddWidgetEarnings":
            ajaxWidgetUpdate=1;
            break;
        case "AddWidgetExpenses":
            ajaxWidgetUpdate=2;
            break;
        case "AddWidgetPurchase":
            ajaxWidgetUpdate=3;
            break;
        case "AdminAddUserList":
            ajaxWidgetUpdate=4;
            break;
        case "AdminAddCashFlow":
            ajaxWidgetUpdate=5;
            break;
        case "AdminAddDocumentList":
            ajaxWidgetUpdate=6;
            break;
        case "AdminAddAdminList":
            ajaxWidgetUpdate=7;
            break;
        default:
            console.log("UpdateWidgetServer2");
            return;
    }

    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "user_widget_pos_set", "payload" : {"position":ajaxUpdateObject, "widget":ajaxWidgetUpdate} }) ,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if(data["Ok"] === undefined){
                console.log(data);
            }
        }
    });

}

function addWidgetToPage(replacementContainer, widgetToAdd){
    var replacementWidget = null;

    if(widgetToAdd === "AddWidgetProfileInfo"){

        $("#WidgetAccountInfo").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget= $("#TemplateAccountWidget");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAccountInfo'));


    }else if(widgetToAdd === "AddWidgetEarnings"){

        $("#WidgetEarnings").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetEarnings");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetEarnings'));
        updateEarningsGraph();

    }else if(widgetToAdd === "AddWidgetExpenses"){

        $("#WidgetExpenses").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetExpenses");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetExpenses'));
        updateExpensesGraph();

    }else if(widgetToAdd === "AddWidgetPurchase"){

        $("#WidgetPurchase").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetPurchase");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetPurchase'));

    }else if(widgetToAdd === "AdminAddUserList"){

        $("#WidgetAdminUserList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminUsers");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminUserList'));

    }else if(widgetToAdd === "AdminAddCashFlow"){

        $("#WidgetAdminCashFlow").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminIncomeExpenses");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminCashFlow'));

    }else if(widgetToAdd === "AdminAddDocumentList"){

        $("#WidgetAdminDocumentList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminDocuments");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminDocumentList'));

    }else if(widgetToAdd === "AdminAddAdminList"){
        $("#WidgetAdminList").replaceWith($("#TemplateEmptyCard").clone()); //delete other widgets of same type to avoid problems with multiple equal id
        replacementWidget = $("#TemplateWidgetAdminAdmins");
        replacementContainer.html(replacementWidget.clone().attr('id', 'WidgetAdminList'));
    }
}

function widgetAddMove(event) {

    if (this === moving && oldX !== null && oldY !== null) {

        var positionX = parseInt($(this).css("left")) + (event.pageX - oldX);
        var positionY = parseInt($(this).css("top"))  + (event.pageY - oldY);

        $(this).css({"left" : positionX + "px"});
        $(this).css({"top" : positionY + "px"});

        oldX = event.pageX;   // update old x/y to current position
        oldY = event.pageY;

        //check that i am not hovering onto one of the possible target of the grid
        var GridCell1 = $("#ContainerGrid1-1");
        var GridCell2 = $("#ContainerGrid1-2");
        var GridCell3 = $("#ContainerGrid2-1");
        var GridCell4 = $("#ContainerGrid2-2");

        if(
            positionX >= GridCell1.position().left &&
            positionX <= (GridCell1.position().left + GridCell1.width()) &&
            positionY >= GridCell1.position().top &&
            positionY <= (GridCell1.position().top + GridCell1.height())
        ){
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeIn();
            lastPosition=GridCell1;
        }else if(
            positionX >= GridCell2.position().left &&
            positionX <= (GridCell2.position().left + GridCell1.width()) &&
            positionY >= GridCell2.position().top &&
            positionY <= (GridCell2.position().top + GridCell1.height())
        ){
            $("#overlay1-2").fadeIn();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition=GridCell2;
        }else if(
            positionX >= GridCell3.position().left &&
            positionX <= (GridCell3.position().left + GridCell1.width()) &&
            positionY >= GridCell3.position().top &&
            positionY <= (GridCell3.position().top + GridCell1.height())
        ){
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeIn();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition=GridCell3;
        }else if(
            positionX >= GridCell4.position().left &&
            positionX <= (GridCell4.position().left + GridCell1.width()) &&
            positionY >= GridCell4.position().top &&
            positionY <= (GridCell4.position().top + GridCell1.height())
        ){
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeIn();
            $("#overlay1-1").fadeOut();
            lastPosition=GridCell4;
        }else{
            $("#overlay1-2").fadeOut();
            $("#overlay2-1").fadeOut();
            $("#overlay2-2").fadeOut();
            $("#overlay1-1").fadeOut();
            lastPosition=null;
        }

    }
}


function updateExpensesGraph(){
    var ExpensesChartCanvas = $("#Expenses_canvas");
    if(ExpensesChartCanvas){
        const data = {
            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],
            datasets: [
                {
                    label: 'Guadagni mensili',
                    data: [100,200,300,400,500],
                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),
                }
            ]
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

function updateEarningsGraph(){
    var EarningsChartCanvas = $("#Earnings_canvas");
    if(EarningsChartCanvas){
        const data = {
            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],
            datasets: [
                {
                    label: 'Guadagni mensili',
                    data: [100,200,300,400,500],
                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),
                }
            ]
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


function ClearUserPageViewBlock(){
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

function checkUserType(){
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "user_type_get", "payload" : [] }) ,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            if(data["UserType"]==="USER"){
               $(".adminOnly").remove();
            }
        },
        error: function() {
            window.location.href = "./login.php";
        }
    });
}


function LoadUserPageDetails(){
    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "user_info_get", "payload" : [] }) ,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
            $("#UserDataName").val(data["Name"]);
            $("#UserDataSurname").val(data["Surname"]);
            $("#UserDataMail").val(data["email"]);

        }
    });
}


function LoadDashboardWidgets(){
    $.ajax("./api/index.php", {
        data: JSON.stringify({"api": "user_dashboard_get", "payload": []}),
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType: 'json',
        success: function (data) {
            var widgetToAdd;
            var targetDiv;
            $.each(data, function (index, value) {

                switch (index){
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
    });
}

function editUserInformations(){
    var name = $("#UserDataName").val();
    var surname = $("#UserDataSurname").val();

    if(name==="" || surname===""){
        return;
    }

    $.ajax("./api/index.php",{
        data: JSON.stringify({"api" : "update_user_info", "payload" : {"name": name, "surname":surname} }) ,
        type: 'POST',
        processData: false,
        contentType: 'application/json',
        dataType:'json',
        success: function (data){
          if(data["Ok"]!==undefined){
              $("#UserDataUpdateSuccessDiv").fadeIn();
          }else{
              $("#UserDataUpdateErrorDiv").fadeIn();
          }
        }
    });

}


$(function (){

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

    $("#TabShowDashboard").click(function(){
        ClearUserPageViewBlock();
        $("#WidgetViewBlock").fadeIn(10);
        $("#TabShowDashboard").addClass("active");
    });

    $("#TabShowUserProfile").click(function(){
        ClearUserPageViewBlock();
        $("#UserProfileViewBlock").fadeIn(10);
        $("#TabShowUserProfile").addClass("active");
        LoadUserPageDetails();
    });

    $("#TabShowUserPurchase").click(function(){
        ClearUserPageViewBlock();
        $("#UserPurchaseViewBlock").fadeIn(10);
        $("#TabShowUserPurchase").addClass("active");
    });

    $("#TabShowUserEarnings").click(function(){
        ClearUserPageViewBlock();
        $("#UserSellingsViewBlock").fadeIn(10);
        $("#TabShowUserEarnings").addClass("active");
    });

    $("#TabShowAdminUserList").click(function(){
        ClearUserPageViewBlock();
        $("#AdminUserList").fadeIn(10);
        $("#TabShowAdminUserList").addClass("active");
    });

    $("#TabShowAdminCashflow").click(function(){
        ClearUserPageViewBlock();
        $("#AdminCashFlow").fadeIn(10);
        $("#TabShowAdminCashflow").addClass("active");
    });

    $("#TabShowAdminDocumentList").click(function(){
        ClearUserPageViewBlock();
        $("#AdminDocumentList").fadeIn(10);
        $("#TabShowAdminDocumentList").addClass("active");
    });

    $("#TabShowAdminAdmins").click(function(){
        ClearUserPageViewBlock();
        $("#AdminAdminList").fadeIn(10);
        $("#TabShowAdminAdmins").addClass("active");
    });

    $("#UserDataEditValues").click(function(){
            editUserInformations();
    });

    //loading page contents
    checkUserType();
    LoadDashboardWidgets();
});