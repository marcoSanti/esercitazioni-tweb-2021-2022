<?php
include "header.html";
include "navbar.php";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="src/js/UserPage.js"></script>
<div style="height: 88px;"></div>
<div id="BannerContainerViewer"></div>
<!--avoid space used by navbar-->
<nav id="SideMenuEditPage" class="bg-info" style="display: none">
    <div id="SideMenuEditPage-Wrapper">
        <div class="sidebar-header">
            <h3>Personalizza la homePage</h3>
        </div>
        <hr>
        <h6>Trascina il widget che preferisci nel quadrante che preferisci!</h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-blue" id="AddWidgetProfileInfo">Profilo</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-blue adminOnly" id="AdminAddUserList"><i class="fas fa-cogs"></i> Elenco utenti</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-blue adminOnly" id="AdminAddAdminList"><i class="fas fa-cogs"></i> Elenco amministratori</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-orange" id="AddWidgetEarnings">Guadagni</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-orange" id="AddWidgetExpenses">Spese</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-orange adminOnly" id="AdminAddCashFlow"><i class="fas fa-cogs"></i> Cashflow</button>
        </h6>
        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-green" id="AddWidgetPurchase">Appunti acquistati</button>
        </h6>

        <h6>
            <button class="btn rounded-pill bg-primary widget-gradient-green adminOnly" id="AdminAddDocumentList"><i class="fas fa-cogs"></i> Elenco appunti in negozio</button>
        </h6>

    </div>
</nav>
<ul class="nav nav-tabs" id="UserPageNavTabs">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#" id="TabShowDashboard">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" id="TabShowUserProfile">Profilo utente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" id="TabShowUserPurchase">Acquisti</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true" id="TabShowUserEarnings">In vendita</a>
    </li>
    <!--solo admins-->
    <li class="nav-item adminOnly">
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true" id="TabShowAdminDocumentList"><i class="fas fa-cogs"></i> Elenco appunti</a>
    </li>
    <li class="nav-item adminOnly">
        <a class="nav-link " href="#" tabindex="-1" aria-disabled="true" id="TabShowAdminUserList"><i class="fas fa-cogs"></i> Elenco utenti</a>
    </li>
    <li class="nav-item adminOnly">
        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true" id="TabShowAdminAdmins"><i class="fas fa-cogs"></i> Elenco amministratori</a>
    </li>


</ul>
<div class="container" id="UserPageContainer">
    <div class="neutralTag" id="WidgetViewBlock">
        <div class="row">
            <!-- linea delle opzioni-->
            <h3>Dashboard
                <button class="btn btn-secondary WidgedEditProfileButton" id="ToggleEditUserPage">Personalizza aspetto</button>
            </h3>
        </div>
        <div class="row">
            <!-- linea dei widget-->
            <div class="col widget-container" id="ContainerGrid1-1">
                <div class="UserPageOverlay" id="overlay1-1"></div>
                <div class="neutralTag ContentsContainerGrid">
                    <div class="card widget emptyWidget"></div>
                </div>
            </div>
            <div class="col widget-container" id="ContainerGrid1-2">
                <div class="UserPageOverlay" id="overlay1-2"></div>
                <div class="neutralTag ContentsContainerGrid">
                    <div class="card widget emptyWidget"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- seconda linea dei widget-->
            <div class="col widget-container" id="ContainerGrid2-1">
                <div class="UserPageOverlay" id="overlay2-1"></div>
                <div class="neutralTag ContentsContainerGrid">
                    <div class="card widget emptyWidget"></div>
                </div>
            </div>
            <div class="col widget-container" id="ContainerGrid2-2">
                <div class="UserPageOverlay" id="overlay2-2"></div>
                <div class="neutralTag ContentsContainerGrid">
                    <div class="card widget emptyWidget"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Linea delle pagine da mostrare -->
    <div class="neutralTag" id="UserProfileViewBlock" style="display: none">
        <div class="px-4 py-3">
            <div class="container" id="UserPageProfileView">
                <div class="row">
                    <div class="col-2">
                        <img src="src/media/user.svg" alt="userPic">
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="UserDataName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="UserDataName" placeholder="Nome">
                        </div>
                        <div class="mb-3">
                            <label for="UserDataSurname" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="UserDataSurname" placeholder="Cognome">
                        </div>
                        <div class="mb-3">
                            <label for="UserDataMail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="UserDataMail" placeholder="email@example.com" disabled>
                        </div>
                        <button class="btn btn-primary" id="UserDataEditValues">Aggiorna i dati</button>
                        <button class="btn btn-warning" id="UserDataEditPassword">Modifica la password</button>
                        <div class="neutral-tag" id="passwordChangeDiv" style="display: none;">
                            <hr>
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Password precedente</label>
                                <input type="password" class="form-control" id="oldPassword" placeholder="Vecchia password">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword1" class="form-label">Nuova password</label>
                                <input type="password" class="form-control" id="newPassword1" placeholder="Nuova password">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword2" class="form-label">Ripeti password</label>
                                <input type="password" class="form-control" id="newPassword2" placeholder="Ripeti password">
                            </div>
                            <button class="btn btn-success" id="btnConfirmChangePassword">Modifica la password</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="neutralTag" id="UserPurchaseViewBlock" style="display: none">
        <h4>
            Elenco appunti acquistati
        </h4>
        <hr>
        <div id="NotesBoughtBox">

        </div>
    </div>
    <div class="neutralTag" id="UserSellingsViewBlock" style="display: none">
        <h4>
            Elenco appunti in vendita
        </h4>
        <hr>

    </div>
    <div id="AdminUserList" class="neutralTag adminOnly" style="display: none">
        <h4>
            Elenco utenti sito
        </h4>
        <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="TableAdminUserList">

            </tbody>
        </table>

    </div>
    <div id="AdminAdminList" class="neutralTag adminOnly" style="display: none">
        <h4>
            Elenco amministratori sito
        </h4>
        <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="TableAdminAdminList">

            </tbody>
        </table>
    </div>
    <div id="AdminDocumentList" class="neutralTag adminOnly" style="display: none">
        <h4>
            Elenco documenti caricati sul sito
        </h4>
        <hr>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Document ID</th>
                    <th>Nome</th>
                    <th>Creatore</th>
                    <th>Prezzo</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody id="TableAdminDocumentList">

            </tbody>
        </table>
    </div>
</div>
<div id="templates" style="display: none">
    <div class="card widget widget-gradient-orange" id="TemplateWidgetEarnings">
        <h5 class="card-header">Ricavi dalle vendite dei tuoi appunti</h5>
        <div class="card-body">
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
        </h5>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        <img src="src/media/user.svg" alt="userPicPlaceholder">
                    </div>
                    <div class="col">
                        <div class="row">
                            placeholder
                        </div>
                        <div class="row">
                            placeholder
                        </div>
                        <div class="row">
                            placeholder
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card widget widget-gradient-orange" id="TemplateWidgetExpenses">
        <h5 class="card-header">Acquisti per insegnamento</h5>
        <div class="card-body">
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
    <div class="card widget widget-gradient-green" id="TemplateWidgetPurchase">
        <h5 class="card-header">Appunti acquistati</h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
        </div>
    </div>
    <!--Admins only templates-->
    <div class="card widget widget-gradient-blue" id="TemplateWidgetAdminUsers">
        <h5 class="card-header">Utenti del sito
        </h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
        </div>
    </div>

    <div class="card widget widget-gradient-orange" id="TemplateWidgetAdminIncomeExpenses">
        <h5 class="card-header">Cashflow ultimo mese
        </h5>
        <div class="card-body">
            <i class="fas fa-arrow-up"></i> 123,45€
            <i class="fas fa-arrow-down"></i> 678,90€
        </div>
    </div>

    <div class="card widget widget-gradient-green" id="TemplateWidgetAdminDocuments">
        <h5 class="card-header">Appunti del sito
        </h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
        </div>
    </div>
    <div class="card widget widget-gradient-blue" id="TemplateWidgetAdminAdmins">
        <h5 class="card-header">Amministratori del sito
        </h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
            </ul>
        </div>
    </div>
    <div class="card widget emptyWidget" id="TemplateEmptyCard"></div>
</div>
<?php
include "footer.html";
?>