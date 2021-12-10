<?php
include "header.html";
include "navbar.php";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="src/js/UserPage.js"></script>
<div style="height: 88px;"></div> <!--avoid space used by navbar-->

<nav id="SideMenuEditPage" class="bg-info" style="display: none">
    <div id="SideMenuEditPage-Wrapper">
        <div class="sidebar-header">
            <h3>Personalizza la homePage</h3>
        </div>
        <hr>
        <h6>Trascina il widget che preferisci nel quadrante che preferisci!</h6>
        <h6><button class="btn rounded-pill bg-primary widget-gradient-blue" id="AddWidgetProfileInfo">Informazioni sul profilo</button></h6>
        <h6><button class="btn rounded-pill bg-primary widget-gradient-purple" id="AddWidgetEranings">Ricavi dalle vendite</button></h6>
        <h6><button class="btn rounded-pill bg-primary widget-gradient-orange" id="AddWidgetExpenses">Spese per acquisti</button></h6>
        <h6><button class="btn rounded-pill bg-primary widget-gradient-yellow" id="AddWidgetBought">Appunti acquistati</button></h6>
    </div>
</nav>
<ul class="nav nav-tabs" id="UserPageNavTabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Profilo utente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Acquisti</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Riepilogo vendite</a>
    </li>
</ul>
<div class="container">

    <div class="row"> <!-- linea delle opzioni-->
        <h3>Dashboard
            <button class="btn btn-secondary WidgedEditProfileButton" id="ToggleEditUserPage">Personalizza aspetto</button>
        </h3>

    </div>
    <div class="row"> <!-- linea dei widget-->

        <div class="col widget-container" id="ContainerGrid1-1">
            <div class="UserPageOverlay" id="overlay1-1"></div>
            <span class="ContentsContainerGrid">
                <div class="card widget emptyWidget" id="TemplateEmptyCard"></div>
            </span>
        </div>

        <div class="col widget-container" id="ContainerGrid1-2">
            <div class="UserPageOverlay" id="overlay1-2"></div>
            <span class="ContentsContainerGrid">
                <div class="card widget emptyWidget" id="TemplateEmptyCard"></div>
            </span>

        </div>
    </div>
    <div class="row"> <!-- seconda linea dei widget-->

        <div class="col widget-container" id="ContainerGrid2-1">
            <div class="UserPageOverlay" id="overlay2-1"></div>
            <span class="ContentsContainerGrid">
                <div class="card widget emptyWidget" id="TemplateEmptyCard"></div>
            </span>
        </div>

        <div class="col widget-container" id="ContainerGrid2-2">
            <div class="UserPageOverlay" id="overlay2-2"></div>
            <span class="ContentsContainerGrid">
                <div class="card widget emptyWidget" id="TemplateEmptyCard"></div>
            </span>
        </div>
    </div>
</div>


<div id="templates" style="display: none">

    <div class="card widget widget-gradient-purple" id="TemplateWidgetEarnings">
        <h5 class="card-header">Ricavi dalle vendite dei tuoi appunti</h5>
        <div class="card-body" >
            <div class="container">
                <div class="row">
                    <div class=" WidgetGraphWrapper col-1">
                        <canvas id="Earnings_canvas"></canvas>
                    </div>
                    <div class="col">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Earning 1</li>
                            <li class="list-group-item">Earning 2</li>
                            <li class="list-group-item">Earning 3</li>
                            <li class="list-group-item">Earning 4</li>
                            <li class="list-group-item">Earning 5</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card widget widget-gradient-blue" id="TemplateAccountWidget">
        <h5 class="card-header">Account
            <button class="btn btn-secondary WidgedEditProfileButton">Modifica account</button>
        </h5>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        <img src="src/media/user.svg" alt="userPicPlaceholder">
                    </div>
                    <div class="col">
                        <div class="row">
                            Marco
                        </div>
                        <div class="row">
                            Santimaria
                        </div>
                        <div class="row">
                            marco.santimaria@edu.unito.it
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card widget widget-gradient-orange" id="TemplateWidgetExpenses">
        <h5 class="card-header">Acquisti per insegnamento</h5>
        <div class="card-body" >
            <div class="container">
                <div class="row">
                    <div class=" WidgetGraphWrapper col-1">
                        <canvas id="Expenses_canvas"></canvas>
                    </div>
                    <div class="col">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Expense 1</li>
                            <li class="list-group-item">Expense 2</li>
                            <li class="list-group-item">Expense 3</li>
                            <li class="list-group-item">Expense 4</li>
                            <li class="list-group-item">Expense 5</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card widget widget-gradient-yellow" id="TemplateWidgetBought">
        <h5 class="card-header">Elenco appunti acquistati
            <button class="btn btn-secondary WidgedEditProfileButton">Vedi tutti</button></h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
        </div>
    </div>

    <div class="card widget emptyWidget" id="TemplateEmptyCard" ></div>

</div>

<?php
include "footer.html";
?>
