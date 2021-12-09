<?php
include "header.html";
include "navbar.php";
?>

    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppunti1">
        <h3>Seleziona il formato</h3>
        <div class="col">
            <div class="card">
                <img src="./src/media/pdf.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">I miei appunti sono digitali</h5>
                    <p class="card-text">Premi qua per caricare i tuoi appunti!.</p>
                    <a href="#" class="btn btn-primary">Continua</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" >
                <img src="./src/media/notes.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">I miei appunti sono cartacei</h5>
                    <p class="card-text">Premi qua per poter organizzare un appuntamento per digitalizzare i tuoi appunti!</p>
                    <a href="#" class="btn btn-primary">Continua</a>
                </div>
            </div>
        </div>
    </div>



    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppunti">
        <h3>Inserisci i dati richiesti</h3>
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option selected>Seleziona</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelectGrid">Universit&agrave;</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option selected>Seleziona</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelectGrid">Seleziona il corso di studi</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option selected>Seleziona</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelectGrid">Seleziona l'anno</label>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option selected>Seleziona</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelectGrid">Seleziona l'insegnamento</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                        <option selected>Seleziona</option>
                        <option value="1">Temi di esame</option>
                        <option value="2">Appunti lezioni</option>
                        <option value="3">Esercitazioni</option>
                    </select>
                    <label for="floatingSelectGrid">Seleziona il tipo di appunti</label>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="Nome del docente">
                <label for="floatingInput">Nome del docente</label>
            </div>
        </div>
        <hr>
        <h5>Carica il file degli appunti in formato .pdf</h5>
        <div class="row g-2">
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Carica gli appunti</label>
            </div>
        </div>
        <hr>
        <div class="row g-2">
            <div class="col"><button class="btn btn-danger">Annulla</button></div>
            <div class="col"> <button class="btn btn-success">Avanti</button></div>
        </div>
    </div>


    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppunti">
        <h3>Prenota la digitalizzazione</h3>
        <hr>
        <div class="row">
            <div class="col-md">
                <div class="form-floating">
                    <input type="date" class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                    <label for="floatingSelectGrid">Data</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <input type="time" class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                    <label for="floatingSelectGrid">Ora</label>
                </div>
            </div>
        </div>
        <h4>Seleziona il punto di digitalizzazione</h4>
        <hr>
        <div class="row">
            <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2816.7877108762764!2d7.65698991562311!3d45.090097866348216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47886db2ab717cef%3A0x405a8e3daad8d89e!2sUniversit%C3%A0%20di%20Torino%20Dipartimento%20di%20Informatica!5e0!3m2!1sit!2sit!4v1638990486193!5m2!1sit!2sit" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <div class="row g-2">
            <div class="col"><button class="btn btn-danger">Annulla</button></div>
            <div class="col"> <button class="btn btn-success">Avanti</button></div>
        </div>
    </div>


    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppunti">
        <h3>Grazie per aver usato il servizio!</h3>
        <img src="src/media/done.svg" id="DoneUploadImg" alt="finish">
        <p id="UploadDoneDigitalizeCode">Il codice della tua prenotazione è: <br> #123ABC</p>
        <a href="./" class="btn btn-success" id="btnFinishUpload">Torna alla homepage</a>
    </div>




<?PHP
include "footer.html";
?>