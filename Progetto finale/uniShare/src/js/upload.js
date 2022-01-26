/**
 * Questa funzione ottiene tutte le informazioni e va a inviarle al 
 * server. NB: non ho potuto usare ajaxCall() in quanto qua la codifica
 * deve essere form-encoded in quando vado a caricare un documento pdf
 * Il funzionamento del metodo è semplice:
 * ottengo tutti i valori del form, successivamente li aggiungo a un form fittizio e invio quello
 */
function uploadData() {
    var exit=false;
    var universita = $("#UploadNoteUniversita").val();
    var annoCorso = $("#UploadNoteAnnoCorso").val();
    var insegnamento = $("#UploadNoteInsegnamento").val();
    var tipoDiAppunti = $("#UploadNoteTipoAppunti").val();
    var titoloAppunti = $("#UploadNoteNomeAppunti").val();
    var nomeDelDocente = $("#UploadNoteNomeDocente").val();
    var file = $("#UploadNoteFile")[0].files[0];

    if(!universita){
        $("#UploadNoteUniversita").css("border-color", "red");
        exit=true;
    } 

    if(!insegnamento){
        $("#UploadNoteInsegnamento").css("border-color", "red");
        exit=true;
    }

    if(!titoloAppunti){
        $("#UploadNoteNomeAppunti").css("border-color", "red");
        exit=true;
    }

    if(!nomeDelDocente){
        $("#UploadNoteNomeDocente").css("border-color", "red");
        exit=true;
    }

    if(!file){
        $("#UploadNoteFile").css("border-color", "red");
        exit=true;
    }

    if(exit){
        showAlert("danger", "Errore", "Riempire tutti i campi!");
        return;
    } 


    var form = new FormData();
    form.append("universita", universita);
    form.append("titoloAppunti", titoloAppunti);
    form.append("annoCorso", annoCorso);
    form.append("insegnamento", insegnamento);
    form.append("tipoDiAppunti", tipoDiAppunti);
    form.append("nomeDelDocente", nomeDelDocente);
    form.append("uploadFile", file);

    $.ajax({
        url: 'api/ApiUpload.php',
        type: 'post',
        data: form,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data) {
            if (data["Ok"] !== undefined) {
                $("#UploadAppunti").hide("slide", { direction: "left" }, 300, function() {
                    $("#UploadAppuntiFinish").fadeIn();
                });
            } 
        }
    }).fail(function(data){
        showAlert("danger", "Errore", "Un errore lato server è stato generato");
        console.log(data);
    });


}

/**
 * Questa funzione carica le informazioni di default della pagina. in particolare le informazioni 
 * sull'autocompletamento delle informazioni sulle università e sugli insegnamenti
 */
function loadPageDefaults() {
    ajaxCall("get_university_list", {}, function(data) {
        $.each(data, function(index, item) {
            $("#UniversitaDataList").append("<option>" + item["item"] + "</option>");
        });
    });

    ajaxCall("get_teaching_list", {}, function(data) {
        $.each(data, function(index, item) {
            $("#InsegnamentoDatalist").append("<option>" + item["item"] + "</option>");
        });
    });
}


$(function() {
    //se utente non è loggato faccio un redirect a login
    userLoginCheck();
    $("#caricaDatiBtn").click(uploadData);
    loadPageDefaults();

})