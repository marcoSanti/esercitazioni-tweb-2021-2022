<?php
include "header.html";
include "navbar.php";

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div style="height: 88px;"></div> <!--avoid space used by navbar-->

<div class="container">
    <div class="row"> <!-- linea delle opzioni-->
        <h3>Dettagli del profilo utente
            <button class="btn btn-secondary WidgedEditProfileButton">Modifica aspetto homepage</button>
        </h3>

    </div>
    <div class="row"> <!-- linea dei widget-->
        <div class="col widget-container">


            <!-- user informations-->
            <div class="card widget widget-gradient-blue">
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


        </div>
        <div class="col widget-container">
            <div class="card widget widget-gradient-purple">
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
                <script>
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
                        var EraningChartCanvas = new Chart(EarningsChartCanvas, config);
                    }
                </script>
            </div>


        </div>
    </div>
    <div class="row"> <!-- seconda linea dei widget-->

        <div class="col widget-container">


            <div class="card widget widget-gradient-yellow">
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


        </div>

        <div class="col widget-container">



            <!--user expences-->
            <div class="card widget widget-gradient-orange">
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
                <script>
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
                </script>
            </div>


        </div>
    </div>
</div>

<?php
include "footer.html";
?>
