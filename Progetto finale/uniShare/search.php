<?php
include "header.html";
include "navbar.php";
?>

<div class="Container" id="SearchPageContainer">
    <div class="row">
        <!--filter options -->
        <div class="col col-2">
            <div id="SearchPageFilterOptions">
                <h4>Filtri di ricerca</h4>
                <div class="row">
                    <label for="inputState" class="form-label">Universit&agrave;</label>
                    <select id="inputState" class="form-select">
                        <option selected>Tutti</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="row">
                    <label for="inputState" class="form-label">Corso di studi</label>
                    <select id="inputState" class="form-select">
                        <option selected>Tutti</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="row">
                    <label for="inputState" class="form-label">Professore</label>
                    <select id="inputState" class="form-select">
                        <option selected>Tutti</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="row">
                    <label for="inputState" class="form-label">Materia</label>
                    <select id="inputState" class="form-select">
                        <option selected>Tutti</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Applica filtri</button>
                </div>
            </div>
        </div>


        <!-- main page -->
        <div class="col" id="SearchPageSecondCol">
            <div class="input-group input-group-lg" id="SearchPageSearchDocument">
                <input type="text" class="form-control" placeholder="Cerca per nome, scuola, autore ecc..." aria-describedby="basic-addon2">
                <span class="btn btn-success" id="basic-addon2"><i class="fas fa-search"></i> Cerca</span>
            </div>

            <!-- mostrare le singole cards-->
            <div class="row" id="SearchPageCardBox">

                <div class="card" style="width: 18rem;">
                    <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>




            </div>

        </div>
    </div>
</div>

<?php
include "footer.html";
?>
