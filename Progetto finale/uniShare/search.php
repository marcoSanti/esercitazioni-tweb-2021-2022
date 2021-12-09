<?php
include "header.html";
include "navbar.php";
?>

<div class="Container PageContent" id="SearchPageContainer">
    <div class="row">
        <!--filter options -->
        <div class="col col-2">
            <div id="SearchPageFilterOptions">
                <h4>Filtri di ricerca</h4>
                <div class="row">
                    <div class="form-floating">
                        <select class="form-select" id="filterByUniversity" aria-label="Floating label select example">
                            <option selected>Qualsiasi</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="filterByUniversity">Universit&agrave;</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating">
                        <select class="form-select" id="filterByUniAddress" aria-label="Floating label select example">
                            <option selected>Qualsiasi</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="filterByUniAddress">Corso di studi</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating">
                        <select class="form-select" id="searchByTeacher" aria-label="Floating label select example">
                            <option selected>Qualsiasi</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="searchByTeacher">Professore</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating">
                        <select class="form-select" id="searchByTeaching" aria-label="Floating label select example">
                            <option selected>Qualsiasi</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="searchByTeaching">Insegnamento</label>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-secondary">Applica filtri</button>
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
