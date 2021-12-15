<?php
include "header.html";
include "navbar.php";
?>

    <script src="src/js/upload.js"></script>

    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppunti">
        <h3>Inserisci i dati richiesti</h3>
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <input class="form-select"  list="UniversitaDataList" aria-label="Floating label select example" id="UploadNoteUniversita">
                    <datalist id="UniversitaDataList">
                    </datalist>
                    <label>Universit&agrave;</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <input class="form-select" list="InsegnamentoDatalist" aria-label="Floating label select example" id="UploadNoteInsegnamento">

                    <datalist id="InsegnamentoDatalist">
                    </datalist>
                    <label>Seleziona l'insegnamento</label>

                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select"  aria-label="Floating label select example" id="UploadNoteAnnoCorso">
                        <option selected>Seleziona</option>
                        <option value="1">Primo</option>
                        <option value="2">Secondo</option>
                        <option value="3">Terzo</option>
                        <option value="4">Quarto</option>
                        <option value="5">Quinto</option>
                        <option value="6">Sesto</option>
                        <option value="7">Settimo</option>
                    </select>
                    <label>Seleziona l'anno</label>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" id="UploadNoteNomeDocente" placeholder="Nome del docente">
                    <label for="UploadNoteNomeDocente">Nome del docente</label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select"  aria-label="Floating label select example" id="UploadNoteTipoAppunti">
                        <option selected>Seleziona</option>
                        <option value="1">Temi di esame</option>
                        <option value="2">Appunti lezioni</option>
                        <option value="3">Esercitazioni</option>
                    </select>

                    <label>Seleziona il tipo di appunti</label>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="UploadNoteNomeAppunti" placeholder="Nome del docente">
                <label for="UploadNoteNomeDocente">Titolo appunti</label>
            </div>
        </div>
        <div class="neutralTag" id="FileUploadAppuntiBlock">
            <div class="row g-2">
                <div class="mb-3">
                    <label for="UploadNoteFile" class="form-label">Carica il file degli appunti in formato .pdf</label>
                    <input class="form-control" type="file" id="UploadNoteFile">
                </div>
            </div>
        </div>
        <hr>
        <div class="row g-2">
            <div class="col"><a href="./upload.php" class="btn btn-danger">Annulla</a></div>
            <div class="col"> <button class="btn btn-success" id="caricaDatiBtn">Avanti</button></div>
        </div>
    </div>



    <div class="row PageContent centeredDiv UploadAppunti" id="UploadAppuntiFinish" style="display: none">
        <h3>Grazie per aver usato il servizio!</h3>
        <img src="src/media/done.svg" id="DoneUploadImg" alt="finish">
        <a href ="./" class="btn btn-success" id="btnFinishUpload">Torna alla homepage</a>
    </div>


<?PHP
include "footer.html";
?>