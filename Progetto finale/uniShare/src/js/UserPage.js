var oldX = null;
var oldY = null;
var moving = null;
var maxZ = 1000;
var lastPosition;

function toggleEditPageMenu(){
    var button = $("#ToggleEditUserPage");
    $("#SideMenuEditPage").toggle("slow");
    var state = button.html();
    if(state === 'Personalizza aspetto'){
        button.html('Salva modifiche');
    }else{
        button.html('Personalizza aspetto');
    }
}

function widgetMouseButtonDown(event) {
    $(this).css({"z-index" : ++maxZ, "position" : "absolute"}); // move clicked square to top
    moving = this;
    oldX = event.pageX;        // remember this square for
    oldY = event.pageY;

}

function widgetMouseButtonUp(event) {
    $("#"+event.target.id).css({"position" : "", "z-index":"", "top": "", "left":""});

    var elementToAdd = event.target.id;

    var replacementContainer = $("#" + lastPosition.attr('id') + " .ContentsContainerGrid");
    console.log(replacementContainer);

    if(elementToAdd === "AddWidgetProfileInfo" && lastPosition){
        replacementContainer.html("<div class=\"UserPageOverlay\" id=\"overlay1-1\"></div>\n" +
            "            <div class=\"card widget widget-gradient-blue\">\n" +
            "                <h5 class=\"card-header\">Account\n" +
            "                    <button class=\"btn btn-secondary WidgedEditProfileButton\">Modifica account</button>\n" +
            "                </h5>\n" +
            "\n" +
            "                <div class=\"card-body\">\n" +
            "                    <div class=\"container\">\n" +
            "                        <div class=\"row\">\n" +
            "                            <div class=\"col mx-auto\">\n" +
            "                                <img src=\"src/media/user.svg\" alt=\"userPicPlaceholder\">\n" +
            "                            </div>\n" +
            "                            <div class=\"col\">\n" +
            "                                <div class=\"row\">\n" +
            "                                    Marco\n" +
            "                                </div>\n" +
            "                                <div class=\"row\">\n" +
            "                                    Santimaria\n" +
            "                                </div>\n" +
            "                                <div class=\"row\">\n" +
            "                                    marco.santimaria@edu.unito.it\n" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "                </div>\n" +
            "            </div>");
    }else if(elementToAdd === "AddWidgetEranings" && lastPosition){
        replacementContainer.html("<div class=\"UserPageOverlay\" id=\"overlay1-2\"></div>\n" +
            "            <div class=\"card widget widget-gradient-purple\">\n" +
            "                <h5 class=\"card-header\">Ricavi dalle vendite dei tuoi appunti</h5>\n" +
            "                <div class=\"card-body\" >\n" +
            "                    <div class=\"container\">\n" +
            "                        <div class=\"row\">\n" +
            "                            <div class=\" WidgetGraphWrapper col-1\">\n" +
            "                                <canvas id=\"Earnings_canvas\"></canvas>\n" +
            "                            </div>\n" +
            "                            <div class=\"col\">\n" +
            "                                <ul class=\"list-group list-group-flush\">\n" +
            "                                    <li class=\"list-group-item\">Earning 1</li>\n" +
            "                                    <li class=\"list-group-item\">Earning 2</li>\n" +
            "                                    <li class=\"list-group-item\">Earning 3</li>\n" +
            "                                    <li class=\"list-group-item\">Earning 4</li>\n" +
            "                                    <li class=\"list-group-item\">Earning 5</li>\n" +
            "                                </ul>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "\n" +
            "                </div>\n" +
            "                <script>\n" +
            "                    var EarningsChartCanvas = $(\"#Earnings_canvas\");\n" +
            "                    if(EarningsChartCanvas){\n" +
            "                        const data = {\n" +
            "                            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],\n" +
            "                            datasets: [\n" +
            "                                {\n" +
            "                                    label: 'Guadagni mensili',\n" +
            "                                    data: [100,200,300,400,500],\n" +
            "                                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),\n" +
            "                                }\n" +
            "                            ]\n" +
            "                        };\n" +
            "                        const config = {\n" +
            "                            type: 'doughnut',\n" +
            "                            data: data,\n" +
            "                            options: {\n" +
            "                                responsive: true,\n" +
            "                                plugins: {\n" +
            "                                    legend: {\n" +
            "                                        // position: 'right',\n" +
            "                                        display: false\n" +
            "                                    },\n" +
            "                                    title: {\n" +
            "                                        display: false,\n" +
            "                                    },\n" +
            "                                    responsive: true,\n" +
            "                                }\n" +
            "                            },\n" +
            "                        };\n" +
            "                        var EraningChartCanvas = new Chart(EarningsChartCanvas, config);\n" +
            "                    }\n" +
            "                </script>\n" +
            "            </div>");
    }else if(elementToAdd === "AddWidgetExpenses" && lastPosition){
        replacementContainer.html("<div class=\"UserPageOverlay\" id=\"overlay2-1\"></div>\n" +
            "            <div class=\"card widget widget-gradient-yellow\">\n" +
            "                <h5 class=\"card-header\">Elenco appunti acquistati\n" +
            "                    <button class=\"btn btn-secondary WidgedEditProfileButton\">Vedi tutti</button></h5>\n" +
            "                <div class=\"card-body\">\n" +
            "                    <ul class=\"list-group list-group-flush\">\n" +
            "                        <li class=\"list-group-item\">An item</li>\n" +
            "                        <li class=\"list-group-item\">A second item</li>\n" +
            "                        <li class=\"list-group-item\">A third item</li>\n" +
            "                    </ul>\n" +
            "                </div>\n" +
            "            </div>");
    }else if(elementToAdd === "AddWidgetBought" && lastPosition){
        replacementContainer.html("<div class=\"UserPageOverlay\" id=\"overlay2-2\"></div>\n" +
            "            <div class=\"card widget widget-gradient-orange\">\n" +
            "                <h5 class=\"card-header\">Acquisti per insegnamento</h5>\n" +
            "                <div class=\"card-body\" >\n" +
            "                    <div class=\"container\">\n" +
            "                        <div class=\"row\">\n" +
            "                            <div class=\" WidgetGraphWrapper col-1\">\n" +
            "                                <canvas id=\"Expenses_canvas\"></canvas>\n" +
            "                            </div>\n" +
            "                            <div class=\"col\">\n" +
            "                                <ul class=\"list-group list-group-flush\">\n" +
            "                                    <li class=\"list-group-item\">Expense 1</li>\n" +
            "                                    <li class=\"list-group-item\">Expense 2</li>\n" +
            "                                    <li class=\"list-group-item\">Expense 3</li>\n" +
            "                                    <li class=\"list-group-item\">Expense 4</li>\n" +
            "                                    <li class=\"list-group-item\">Expense 5</li>\n" +
            "                                </ul>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "\n" +
            "                </div>\n" +
            "                <script>\n" +
            "                    var ExpensesChartCanvas = $(\"#Expenses_canvas\");\n" +
            "                    if(ExpensesChartCanvas){\n" +
            "                        const data = {\n" +
            "                            labels: ['Appunto1', 'Appunto2', 'Appunto3', 'Appunto4', 'Appunto5'],\n" +
            "                            datasets: [\n" +
            "                                {\n" +
            "                                    label: 'Guadagni mensili',\n" +
            "                                    data: [100,200,300,400,500],\n" +
            "                                    backgroundColor: Object.values(['#4dc9f6', '#f67019', '#f53794', '#537bc4', '#acc236', '#166a8f', '#00a950', '#58595b', '#8549ba']),\n" +
            "                                }\n" +
            "                            ]\n" +
            "                        };\n" +
            "                        const config = {\n" +
            "                            type: 'doughnut',\n" +
            "                            data: data,\n" +
            "                            options: {\n" +
            "                                responsive: true,\n" +
            "                                plugins: {\n" +
            "                                    legend: {\n" +
            "                                        // position: 'right',\n" +
            "                                        display: false\n" +
            "                                    },\n" +
            "                                    title: {\n" +
            "                                        display: false,\n" +
            "                                    },\n" +
            "                                    responsive: true,\n" +
            "                                }\n" +
            "                            },\n" +
            "                        };\n" +
            "                        var ExpensesChart = new Chart(ExpensesChartCanvas, config);\n" +
            "                    }\n" +
            "                </script>\n" +
            "            </div>");
    }


    $("#overlay1-2").fadeOut();
    $("#overlay2-1").fadeOut();
    $("#overlay2-2").fadeOut();
    $("#overlay1-1").fadeOut();
    moving = null;
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




$(function (){
    $("#ToggleEditUserPage").click(toggleEditPageMenu);
    $("#AddWidgetProfileInfo").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetBought").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetEranings").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });
    $("#AddWidgetExpenses").on({
        mousedown: widgetMouseButtonDown,
        mouseup: widgetMouseButtonUp,
        mousemove: widgetAddMove,
    });


});